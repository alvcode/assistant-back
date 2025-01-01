<?php

namespace App\Controller\RequestModels;

use App\Exception\ValidationHttpException;
use App\Layer\Base\ErrorsExceptionDto\DetailErrorExceptionDto;
use App\Layer\Base\ErrorsExceptionDto\DetailErrorExceptionDtoCollection;
use App\Layer\Base\ErrorsExceptionDto\ErrorExceptionDto;
use App\Layer\Base\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestModelBase extends Model
{
    public function __construct(private readonly ValidatorInterface $validator)
    {
        $this->populate();
    }

    public function validate(): static
    {
        $errors = $this->validator->validate($this);

        $detailsDtoCollection = new DetailErrorExceptionDtoCollection();
        /** @var $message ConstraintViolation  */
        foreach ($errors as $message) {
            $detailsDtoCollection->add(
                new DetailErrorExceptionDto(
                    !empty($message->getPropertyPath()) ? $message->getPropertyPath() : null,
                    $message->getMessage()
                )
            );
        }

        if ($detailsDtoCollection->existsItems()) {
            throw new ValidationHttpException(
                new ErrorExceptionDto(ErrorExceptionDto::TYPE_INPUT_VALIDATE, $detailsDtoCollection)
            );
        }

        return $this;
    }

    public function getRequest(): Request
    {
        return Request::createFromGlobals();
    }

    protected function populate(): void
    {
        $this->loadFromArray($this->getRequest()->toArray());
//        foreach ($this->getRequest()->toArray() as $property => $value) {
//            if (property_exists($this, $property)) {
//                $this->{$property} = $value;
//            }
//        }
    }
}
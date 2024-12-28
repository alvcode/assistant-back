<?php

namespace App\Controller\RequestModels;

use App\Exception\ValidationHttpException;
use App\Layer\Base\ErrorsExceptionDto\DetailErrorExceptionDto;
use App\Layer\Base\ErrorsExceptionDto\DetailErrorExceptionDtoCollection;
use App\Layer\Base\ErrorsExceptionDto\ErrorExceptionDto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestModelBase
{
    public function __construct(protected ValidatorInterface $validator)
    {
        $this->populate();
    }

    public function validate(): bool
    {
        $errors = $this->validator->validate($this);

        //$messages = ['message' => 'validation_failed', 'errors' => []];

        $errorsList = [];
        $detailsDtoCollection = new DetailErrorExceptionDtoCollection();
        /** @var \Symfony\Component\Validator\ConstraintViolation  */
        foreach ($errors as $message) {
            //$detailErrorExceptionDto = new DetailErrorExceptionDto($message->getPropertyPath(), $message->getMessage());
            $detailsDtoCollection->add(
                new DetailErrorExceptionDto($message->getPropertyPath(), $message->getMessage())
            );
//            $errorsList[] = [
//                'property' => $message->getPropertyPath(),
//                'value' => $message->getInvalidValue(),
//                'message' => $message->getMessage(),
//            ];
        }

        if ($detailsDtoCollection->existsItems()) {
            throw new ValidationHttpException(
                new ErrorExceptionDto(ErrorExceptionDto::TYPE_INPUT_VALIDATE, $detailsDtoCollection)
            );
//            foreach ()
//            $errorExceptionDto = new ErrorExceptionDto();

        }

        return true;
    }

    public function getRequest(): Request
    {
        return Request::createFromGlobals();
    }

    protected function populate(): void
    {
        foreach ($this->getRequest()->toArray() as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }
}
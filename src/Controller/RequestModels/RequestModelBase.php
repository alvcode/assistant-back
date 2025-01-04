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
    private Request $request;

    public function __construct(
        private readonly ValidatorInterface $validator,
    )
    {
    }

    public function validate(): static
    {
        $this->populate();

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

    public function setRequest(Request $request): static
    {
        $this->request = $request;
        return $this;
    }

    protected function populate(): void
    {
        if ($this->request->isMethod('GET')) {
            $this->loadFromArray($this->request->query->all());
        } else {
            $this->loadFromArray($this->request->toArray());
        }
    }
}
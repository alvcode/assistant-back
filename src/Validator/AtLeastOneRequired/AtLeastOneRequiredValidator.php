<?php

declare(strict_types=1);

namespace App\Validator\AtLeastOneRequired;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class AtLeastOneRequiredValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof AtLeastOneRequiredConstraint) {
            throw new UnexpectedTypeException($constraint, AtLeastOneRequiredConstraint::class);
        }

        $existsNotEmpty = false;
        foreach ($constraint->fields as $fieldName) {
            if (!empty($value->$fieldName)) {
                $existsNotEmpty = true;
            }
        }

        if (!$existsNotEmpty) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ fields }}', implode(', ', $constraint->fields))
                ->addViolation();
        }
    }
}
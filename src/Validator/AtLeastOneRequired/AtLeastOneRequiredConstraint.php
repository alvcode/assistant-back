<?php

declare(strict_types=1);

namespace App\Validator\AtLeastOneRequired;

use App\InfrastructureFacades\Lang;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
class AtLeastOneRequiredConstraint extends Constraint
{
    public string $message = '';
    public array $fields;

    public function __construct(array $fields = [], mixed $options = null, ?array $groups = null, mixed $payload = null)
    {
        if (empty($fields)) {
            throw new \InvalidArgumentException('Параметр "fields" обязателен для заполнения');
        }
        $this->message = Lang::t('error_at_least_one_required_validation');
        $this->fields = $fields;

        parent::__construct($options, $groups, $payload);
    }

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy(): string
    {
        return AtLeastOneRequiredValidator::class;
    }
}
<?php

namespace App\Layer\Base\SimpleObjects\Dto;

use App\Layer\Base\BaseDto;

class SimpleIntDto extends BaseDto
{
    protected int $value;

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
    }
}
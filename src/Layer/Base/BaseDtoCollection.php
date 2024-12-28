<?php

namespace App\Layer\Base;

class BaseDtoCollection extends CollectionModel
{
    /**
     * @return BaseDto[] Array of BaseOutput objects
     */
    public function all(): array
    {
        return parent::all();
    }
}
<?php

namespace App\Layer\Base;


class BaseEntityCollection extends CollectionModel
{
    /**
     * @return BaseEntity[] Array of BaseEntity objects
     */
    public function all(): array
    {
        return parent::all();
    }
}

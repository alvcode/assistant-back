<?php

declare(strict_types=1);

namespace App\Controller\ViewModels;

abstract class ViewModelBase
{
    protected array $result = [];

    abstract public function getResult(): array;
}
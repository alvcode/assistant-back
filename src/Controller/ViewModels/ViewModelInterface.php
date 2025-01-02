<?php

declare(strict_types=1);

namespace App\Controller\ViewModels;

interface ViewModelInterface
{
    public function getResult(): array;
}
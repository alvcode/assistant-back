<?php

namespace App\Controller\RequestModels\Auth;

use App\Controller\RequestModels\RequestModelBase;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterRM extends RequestModelBase
{
    #[Assert\Type('string')]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 3, max: 180)]
    public $login;

    #[Assert\Type('string')]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 6)]
    public $password;
}
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthController extends AbstractController
{
    #[Route('/v1/auth/register', name: 'auth_register', methods: ['POST'])]
    public function register(Request $request): Response
    {

        //$request->query->get('name');
        return $this->json(['result' => ['ok']]);
        //return ['success' => true];
//        return $this->render('default/index.html.twig', [
//            'controller_name' => 'DefaultController',
//        ]);

    }
}

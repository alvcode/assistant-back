<?php

namespace App\Controller;

use App\Controller\RequestModels\Auth\RegisterRM;
use App\Exception\ValidationHttpException;
use App\InfrastructureFacades\Lang;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Attribute\Route;

class AuthController extends AbstractController
{
    #[Route('/api/auth/register', name: 'auth_register', methods: ['POST'])]
    public function register(RegisterRM $request): Response
    {
        $request = $request->validate();

        var_dump($request->toArray()); exit();
        //throw new \Exception("test1");


//
//        if (count($errors) > 0) {
//            return $this->json(['errors' => (string) $errors], 400);
//        }
//
//        $processedIds = []; // Массив для хранения ID последних 8 обработанных записей
//        $maxSize = 8; // Максимальное количество ID, которые нужно хранить
//        $currentIndex = 0;
//
//        for ($i = 0; $i <= 100; $i++) {
//            $id = $i; // Получаем ID текущей записи
//            $processedIds[$currentIndex] = $id;
//            $currentIndex = ($currentIndex + 1) % $maxSize;
//        }
//
//        return $this->json(['result' => $processedIds]);

        //return ['success' => true];
//        return $this->render('default/index.html.twig', [
//            'controller_name' => 'DefaultController',
//        ]);

    }
}

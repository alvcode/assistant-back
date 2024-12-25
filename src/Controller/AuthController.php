<?php

namespace App\Controller;

use App\Controller\RequestModels\Auth\RegisterRM;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthController extends AbstractController
{
    #[Route('/api/auth/register', name: 'auth_register', methods: ['POST'])]
    public function register(Request $request, ValidatorInterface $validator): Response
    {
        $data = json_decode($request->getContent(), true);
var_dump($data); exit();
        $registerRM = new RegisterRM();
        $registerRM->login = $data['login'];
        $registerRM->password = $data['password'];

        $errors = $validator->validate($registerRM);

        if (count($errors) > 0) {
            return $this->json(['errors' => (string) $errors], 400);
        }

        $processedIds = []; // Массив для хранения ID последних 8 обработанных записей
        $maxSize = 8; // Максимальное количество ID, которые нужно хранить
        $currentIndex = 0;

        for ($i = 0; $i <= 100; $i++) {
            $id = $i; // Получаем ID текущей записи
            $processedIds[$currentIndex] = $id;
            $currentIndex = ($currentIndex + 1) % $maxSize;
        }

        return $this->json(['result' => $processedIds]);

        //return ['success' => true];
//        return $this->render('default/index.html.twig', [
//            'controller_name' => 'DefaultController',
//        ]);

    }
}

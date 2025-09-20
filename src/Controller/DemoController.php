<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DemoController extends AbstractController
{
    #[Route('/hello', name: 'app_demo', methods: ["GET"])]
    public function hello(): Response
    {
        return $this->render('demo/hello.html.twig');
    }

    #[Route('/hello/{name}', name: 'get_hello', methods: ["GET"])]
    public function hello2(string $name): Response
    {
        return $this->render('demo/hello2.html.twig', [
            'name' => $name
        ]);
    }

    #[Route('/hello/courses', name: 'get_courses', methods: ["GET"])]
    public function hello3(): Response
    {
        $courses = array("patates","fromage","chocolat","frites");
        return $this->render('demo/hello2.html.twig', [
            'courses' => $courses
        ]);
    }
}

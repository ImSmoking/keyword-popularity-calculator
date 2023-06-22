<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    #[Route('/hello', name: 'hello')]
    public function helloAction(): Response
    {
        return new Response("<html><h1>Hello There!</h1></html>");
    }
}
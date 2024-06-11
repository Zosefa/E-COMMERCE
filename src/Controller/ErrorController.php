<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ErrorController extends AbstractController
{
    #[Route('/error', name: 'app_error')]
    public function show(): Response
    {
        return $this->render('error/error404.html.twig', [
            'controller_name' => 'ErrorController',
        ]);
    }

    // #[Route('/error/{code}', name: 'error')]
    // public function show(int $code): Response
    // {
    //     $template = match ($code) {
    //         403 => 'error/error403.html.twig',
    //         404 => 'error/error404.html.twig',
    //         500 => 'error/error500.html.twig',
    //         default => 'bundles/TwigBundle/Exception/error.html.twig',
    //     };

    //     return $this->render($template, ['code' => $code]);
    // }
}

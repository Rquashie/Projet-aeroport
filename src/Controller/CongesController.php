<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CongesController extends AbstractController
{
    #[Route('/conges', name: 'app_conges')]
    public function index(): Response
    {
        return $this->render('conges/index.html.twig', [
            'controller_name' => 'CongesController',
        ]);
    }
}

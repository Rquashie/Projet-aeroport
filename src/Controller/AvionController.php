<?php

namespace App\Controller;

use App\Entity\Avion;
use App\Entity\Utilisateur;
use App\Form\AvionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AvionController extends AbstractController
{
    #[Route('/avion', name: 'app_avion')]
    public function index(): Response
    {
        return $this->render('avion/index.html.twig', [
            'controller_name' => 'AvionController',
        ]);
    }

    #[Route('/avion/ajouter', name: 'ajouter_avion')]
    public function ajouterUtilisateur(Request $request, EntityManagerInterface $entityManager): Response
    {
        $avion = new Avion();
        $form = $this->createForm(AvionType::class, $avion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->isValid()) {
                dump($avion);
                $entityManager->persist($avion);
                $entityManager->flush();
                return $this->redirectToRoute('app_avion');
            } else {
                dump($form->getErrors());
            }
        }
        return $this->render('avion/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

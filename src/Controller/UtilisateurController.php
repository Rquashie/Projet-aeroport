<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UtilisateurController extends AbstractController
{
    #[Route('/utilisateur', name: 'app_utilisateur')]
    public function index(): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

    #[Route('/utilisateur/ajouter', name: 'ajouter_user')]
    public function ajouterUtilisateur(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->isValid()) {
                dump($user);
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute('app_utilisateur');
            } else {
                dump($form->getErrors());
            }
        }
        return $this->render('utilisateur/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
            }
} ;



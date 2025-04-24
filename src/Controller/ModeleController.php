<?php

namespace App\Controller;

use App\Entity\Modele;
use App\Form\ModeleType ;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ModeleController extends AbstractController
{
    #[Route('/modele', name: 'app_modele')]
    public function index(): Response
    {
        return $this->render('modele/index.html.twig', [
            'controller_name' => 'ModeleController',
        ]);
    }

    #[Route('/modele/ajouter', name: 'ajouter_modele')]
    public function ajouterModele(Request $request , EntityManagerInterface
                                       $entityManager) : Response
    {
        $modele = new Modele();
        $form = $this->createForm(ModeleType::class, $modele);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($modele);
            $entityManager->flush();
            return $this->redirectToRoute('ajouter_modele');
        }

        return $this->render('modele/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

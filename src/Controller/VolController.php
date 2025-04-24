<?php

namespace App\Controller;

use App\Entity\Vol;
use App\Form\VolType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response ;
use Symfony\Component\Routing\Attribute\Route;

final class VolController extends AbstractController
{
    #[Route('/vol/ajouter', name: 'ajouter_vol')]
    public function ajouterVol(Request $request , EntityManagerInterface
     $entityManager) : Response
    {
        $vol = new Vol();
        $form = $this->createForm(VolType::class, $vol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vol);
            $entityManager->flush();
            return $this->redirectToRoute('ajouter_vol');
        }

        return $this->render('vol/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

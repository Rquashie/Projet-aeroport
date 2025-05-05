<?php

namespace App\Controller;

use App\Entity\Avion;
use App\Form\Avion1Type;
use App\Form\AvionType;
use App\Repository\AvionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/avion')]
final class AvionController extends AbstractController
{
    #[Route('/index',name: 'app_avion_index', methods: ['GET'])]
    public function index(AvionRepository $avionRepository): Response
    {
        if(!$this->isGranted('ROLE_USER')&& !$this->isGranted('ROLE_PILOTE')
            && !$this->isGranted('ROLE_VOL') && !$this->isGranted('ROLE_ADMIN') ){
            return $this->render('index.html.twig', [
                'show_modal' => 'avionConnexion',
            ]);
        }

        else if ($this->isGranted('ROLE_USER') || $this->isGranted('ROLE_PILOTE')) {
            return $this->render('index.html.twig', [
                'show_modal' => 'vol',
            ]);
        }

        return $this->render('avion/index.html.twig', [
            'avions' => $avionRepository->findAll(),
            'show_modal'=>false
        ]);
    }

    #[Route('/new', name: 'app_avion_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $avion = new Avion();
        $form = $this->createForm(AvionType::class, $avion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($avion);
            $entityManager->flush();

            return $this->redirectToRoute('app_avion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('avion/new.html.twig', [
            'avion' => $avion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_avion_show', methods: ['GET'])]
    public function show(Avion $avion): Response
    {
        return $this->render('avion/show.html.twig', [
            'avion' => $avion,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_avion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Avion $avion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AvionType::class, $avion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_avion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('avion/edit.html.twig', [
            'avion' => $avion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_avion_delete', methods: ['POST'])]
    public function delete(Request $request, Avion $avion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$avion->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($avion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_avion_index', [], Response::HTTP_SEE_OTHER);
    }
}

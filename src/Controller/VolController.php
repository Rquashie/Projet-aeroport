<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Vol;
use App\Form\VolType;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use App\Repository\VolRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use FPDF;


final class VolController extends AbstractController
{
    #[Route('/vol',name: 'app_vol_index', methods: ['GET'])]
    public function index(VolRepository $volRepository , UserRepository $userRepository): Response
    {
        if(!$this->isGranted('ROLE_USER')&& !$this->isGranted('ROLE_PILOTE')
            && !$this->isGranted('ROLE_VOL') && !$this->isGranted('ROLE_ADMIN') ){
            return $this->render('index.html.twig', [
                'show_modal' => 'volConnexion',
            ]);
        }

        if ($this->isGranted('PILOTE') || ($this->isGranted('USER') && !$this->isGranted('ROLE_ADMIN'))) {
            return $this->render('index.html.twig', [
                'show_modal' => 'vol',
            ]);
        }
        return $this->render('vol/index.html.twig', [
            'vols' => $volRepository->findAll(),
            'show_modal' => false ]);
    }

    #[Route('/vol/new', name: 'app_vol_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vol = new Vol();
        $form = $this->createForm(VolType::class, $vol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vol);
            $entityManager->flush();

            return $this->redirectToRoute('app_vol_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vol/new.html.twig', [
            'vol' => $vol,
            'form' => $form,
        ]);
    }

    #[Route('vol/{id}', name: 'app_vol_show', methods: ['GET'])]
    public function show(Vol $vol ): Response
    {
        return $this->render('vol/show.html.twig', [
            'vol' => $vol,
        ]);
    }

    #[Route('/vol/{id}/edit', name: 'app_vol_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vol $vol, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VolType::class, $vol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vol_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vol/edit.html.twig', [
            'vol' => $vol,
            'form' => $form,
        ]);
    }

    #[Route('/vol/{id}', name: 'app_vol_delete', methods: ['POST'])]
    public function delete(Request $request, Vol $vol, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vol->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($vol);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vol_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/vol/passagers/{id}', name: 'app_vol_show_passagers', methods: ['GET'])]
    public function showPassagersVol(Vol $vol ,  VolRepository $volRepository ,
    ReservationRepository $reservationRepository): Response
    {

        return $this->render('vol/passagers.html.twig', [
            'vol' => $vol,
            'vols'=>$volRepository->findAll() ,
            'reservations' => $reservationRepository->findBy(['refVol'=>$vol]),
        ]);
    }
    #[Route('/vol/pilotes/{id}', name: 'app_vol_show_pilotes', methods: ['GET'])]
    public function showPilotesVol(Vol $vol ,  VolRepository $volRepository ,
                                     ReservationRepository $reservationRepository ): Response
    {
        $vols = $volRepository->findAll() ;
        $pilote =$vol ->getRefPilote() ;

        return $this->render('vol/pilotes.html.twig', [
            'vol' => $vol,
            'vols'=> $vols ,
             'pilote'=>$pilote,] );
    }


}

<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Vol;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/reservation')]
final class ReservationController extends AbstractController
{
    #[Route(name: 'app_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository): Response
    {
        if (!$this->isGranted('ROLE_USER') && !$this->isGranted('ROLE_PILOTE')
            && !$this->isGranted('ROLE_VOL')) {
            return $this->render('index.html.twig', [
                'show_modal' => 'reservationConnexion',
            ]);
        } else if ($this->isGranted('ROLE_PILOTE') || $this->isGranted('ROLE_VOL')) {
            return $this->render('index.html.twig', [
                'show_modal' => 'reservation',
            ]);
        }
        $reservations = $reservationRepository->findBy(['refUtilisateur' => $this->getUser()]);

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
            'show_modal' => false
        ]);
    }

    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('reservation/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation, Vol $vol, ReservationRepository $reservationRepository): Response
    {

        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
            'vol' => $vol
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    /**
     * @throws \DateMalformedStringException
     */
    #[Route('/{id}/delete', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager, ReservationRepository $reservationRepository): Response
    {
        $echeance = $reservationRepository->calculDateEcheance($reservation->getRefVol()->getDateDepart());
        if ($this->isCsrfTokenValid('delete' . $reservation->getId(), $request->getPayload()->getString('_token'))
            && $echeance >= 2) {

            $entityManager->remove($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }
        else if ($echeance < 2) {
            return $this->render('reservation/index.html.twig', [
                'show_modal' => 'annulerReservation',
                'reservations' => $reservationRepository->findBy(['refUtilisateur' => $this->getUser()]),]);
        }

        return $this->render('reservation/index.html.twig', [
            'show_modal' => false ,
            'reservations' => $reservationRepository->findBy(['refUtilisateur' => $this->getUser()]),
        ]);

    }
}

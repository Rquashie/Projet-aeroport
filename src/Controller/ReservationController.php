<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Vol;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\VolRepository;
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
            && !$this->isGranted('ROLE_VOL') && !$this->isGranted('ROLE_ADMIN')) {
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

    /**
     * @throws \DateMalformedStringException
     */
    #[Route('/reservation/new/{idVol}', name: 'app_reservation_new')]
    public function new(
        int $idVol,
        Request $request,
        EntityManagerInterface $entityManager,
        VolRepository $volRepository,
        ReservationRepository $reservationRepository
    ): Response {
        $vol = $volRepository->find($idVol);
        if (!$vol) {
            throw $this->createNotFoundException("Vol non trouvé.");
        }

        $reservation = new Reservation();
        $reservation->setRefVol($vol);
        $reservation->setRefUtilisateur($this->getUser());
        $reservationRepository->augmentePrixBillet($reservation,$vol);

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index');
        }

        return $this->render('reservation/new.html.twig', [
            'form' => $form,
            'reservation' => $reservation,
            'vol' => $vol,
        ]);
    }
    #[Route('/reservation/select', name: 'app_reservation_select')]
    public function select(VolRepository $volRepository): Response
    {
        $vols = $volRepository->findAll();

        return $this->render('reservation/select.html.twig', [
            'vols' => $vols,
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

        return $this->render('reservation/editPilote.html.twig', [
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
    #[Route('/reservation/{id}/pdf', name: 'app_reservation_generer_pdf')]
    public function exporterTicketPDF(Reservation $reservation)
    {
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);

        $pdf->Cell(0, 10, 'Ticket de Reservation', 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(50, 10, 'Depart : ' . $reservation->getRefVol()->getDateDepart()->format('d-m-Y'), 0, 1, 'L');
        $pdf->Ln(8);
        $pdf->Cell(50, 10, 'Destination : ' .$reservation->getRefVol()->getVilleArrive());
        $pdf->Ln(8);
        $pdf->Ln(8);
        $pdf->Cell(50, 10, 'Prix : ' . $reservation->getPrixBillet() . ' euros');
        $pdf->Ln(8);
        $pdf->Cell(50, 10, 'Numero Reservation : ' . $reservation->getId());

        $pdf->Output('D', 'ticket_reservation_' . $reservation->getRefVol()->getVilleArrive() .$reservation->getRefVol()->getVilleDepart(). '.pdf');

        exit;
    }
    #[Route('/reservation/{id}/pdf', name: 'app_reservation_generer_pdf')]
    public function genererPdf(Reservation $reservation): Response
    {
        $this->exporterTicketPDF($reservation);
        return new Response();
    }

}

<?php

namespace App\Controller;

use App\Repository\VolRepository;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/index', name: 'app_index')]
    public function index(): Response
    {


        return $this->render('index.html.twig');

    }

    #[Route('/index/recherche', name: 'app_index_recherche', methods: ['GET'])]
    public function recherche(\Symfony\Component\HttpFoundation\Request $request, VolRepository $volRepository): Response
    {
        $destination = $request->query->get('destination');
        $date = $request->query->get('date');
        $prixString = $request->query->get('prix');

        $prix = null;
        if ($prixString !== null && $prixString !== '') {
            $prix = floatval($prixString);
        }

        $vols = [];
        if ($destination || $date || $prix !== null) {
            $vols = $volRepository->searchByDestination($destination, $date, $prix);

            return $this->render('resultats_recherches.html.twig', [
                'vols' => $vols,
                'search' => $destination,
            ]);
        }

        return $this->render('index.html.twig');

    }
}
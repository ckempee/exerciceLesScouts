<?php

namespace App\Controller;

use App\Repository\WsGroupeUniteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WsGroupeUniteController extends AbstractController
{
    #[Route('/groupe-unite', name: 'app_groupe_unite')]
    public function index(WsGroupeUniteRepository $groupeUniteRepository): Response
    {
        $groupeUnite = $groupeUniteRepository->findAll();

        return $this->render('ws_groupe_unite/index.html.twig', [
            'groupeUnite' => $groupeUnite
        ]);
    }
}

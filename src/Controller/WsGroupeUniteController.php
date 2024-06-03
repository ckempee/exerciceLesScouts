<?php

namespace App\Controller;

use App\Entity\WsGroupeUnite;
use App\Repository\WsUniteRepository;
use App\Repository\WsGroupeUniteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WsGroupeUniteController extends AbstractController
{
    #[Route('/groupeUnite/{id}', name: 'uniteInCategorie', methods: ['GET', 'POST'])]
    public function index(WsGroupeUnite $groupeUnite, WsUniteRepository $unitRepository): Response
    {
       
        $wsUnites = $groupeUnite->getWsUnites();

        return $this->render('ws_groupe_unite/index.html.twig', [
            'groupeUnite' => $groupeUnite,
            'wsUnites' => $wsUnites,

            
        ]);
    }
}

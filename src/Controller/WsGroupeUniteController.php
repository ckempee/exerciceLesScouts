<?php

namespace App\Controller;

use App\Entity\WsGroupeUnite;
use App\Repository\WsSectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WsGroupeUniteController extends AbstractController
{
    #[Route('/groupeUnite/{id}', name: 'uniteInCategorie', methods: ['GET', 'POST'])]
    public function index(WsGroupeUnite $groupeUnite, WsSectionRepository $sectionRepository): Response
    {
        $wsUnites = $groupeUnite->getWsUnites();
        $membresParUnite = $sectionRepository->membresParUnite();

        // Create an associative array to match unit names with their member counts
        $membresParUniteMap = [];
        foreach ($membresParUnite as $item) {
            $membresParUniteMap[$item['unite']] = $item['total'];
        }

        return $this->render('ws_groupe_unite/index.html.twig', [
            'groupeUnite' => $groupeUnite,
            'wsUnites' => $wsUnites,
            'membresParUnite' => $membresParUniteMap,
        ]);
    }
}

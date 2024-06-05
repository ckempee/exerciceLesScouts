<?php

namespace App\Controller;

use App\Entity\WsUnite;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\WsSectionRepository;
use App\Repository\WsUniteRepository;

class WsUniteController extends AbstractController
{
    #[Route('/wsunite/{id}', name: 'wsUnite', methods: ['GET', 'POST'])]
    public function index($id, WsUnite $WsUnite, WsSectionRepository $sectionRepository, WsUniteRepository $uniteRepository): Response
    {
       //je récupère l'id de l'unité en question pour calculer le nombre de membre vue que je passe en paramètre
       $unite = $uniteRepository->find($id);

       if (!$unite) {
           throw $this->createNotFoundException('Unité non trouvée');
       }

       // j'utilise la méthode du repository pour obtenir le nombre de membres
       $nombreMembres = $sectionRepository->countMembersByUnite($id);
       $branches = $sectionRepository->membresParBrancheDansUnite($id);

       // je passe  l'unité et le nombre de membres à la vue pour les afficher
       return $this->render('ws_unite/index.html.twig', [
           'unite' => $unite,
           'nombreMembres' => $nombreMembres,
           'branches' => $branches,
       ]);
   }

}



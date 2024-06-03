<?php
namespace App\Controller;

use App\Repository\WsMembreRepository;
use App\Repository\WsBrancheRepository;
use App\Repository\WsUniteRepository;
use App\Repository\WsGroupeUniteRepository;
use App\Repository\WsSectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashBoardController extends AbstractController
{
    //calculer le nombre total des membres, groupes, unité et branche pour les afficher sur la page principale
    #[Route('/dashboard', name: 'app_dash_board')]
    public function index(WsMembreRepository $membreRepository, WsBrancheRepository $brancheRepository, WsUniteRepository $uniteRepository, WsGroupeUniteRepository $groupeUniteRepository, WsSectionRepository $sectionRepository): Response
    {
        $totalMembers = $membreRepository->count([]);
        $totalUnits = $uniteRepository->count([]);
        $totalGroups = $groupeUniteRepository->count([]);
        $totalBranche = $brancheRepository->count([]);

        // calculer le nombre de membres par branches(baladins, louveteaux,etc...) gravce a la méthode créée dans le repository
        $membresParBranche = $sectionRepository->membresParBranche();

        //récupérer le nom de tous les groupes d'unités pour les afficher sur une carte interactive
        $groupNames = $groupeUniteRepository->findAllGroupeUniteNames();

        foreach ($membresParBranche as &$data) {
            $data['percentage'] = ($totalMembers > 0) ? round(($data['total'] / $totalMembers) * 100, 2) : 0;
        }

        return $this->render('dash_board/index.html.twig', [
            'totalMembres' => $totalMembers,
            'totalUnite' => $totalUnits,
            'totalGroupeUnite' => $totalGroups,
            'totalBranche' => $totalBranche,
            'membresParBranche' => $membresParBranche,
            'groupNames' => $groupNames,

        ]);
    }
}

<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Repository\WsMembreRepository;
use App\Repository\WsBrancheRepository;
use App\Repository\WsUniteRepository;
use App\Repository\WsGroupeUniteRepository;
use App\Repository\WsSectionRepository;
use App\Entity\WsGroupeUnite;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Routing\Annotation\Route;

class DashBoardController extends AbstractController
{
    //ce que je veux afficher: nombre total membres OK, nombres groupe OK, nombre unité OK, charte branche OK, carte avec nom groupe OK, popup OK
    #[Route('/dashboard', name: 'dashboard')]
    public function index(EntityManagerInterface $entityManager, WsMembreRepository $membreRepository, WsBrancheRepository $brancheRepository, WsUniteRepository $uniteRepository, WsGroupeUniteRepository $groupeUniteRepository, WsSectionRepository $sectionRepository): Response
    {
        $totalMembers = $membreRepository->count([]);
        $totalUnits = $uniteRepository->count([]);
        $totalGroups = $groupeUniteRepository->count([]);
        $totalBranche = $brancheRepository->count([]);

        // calculer le nombre de membres par branches(baladins, louveteaux,etc...) gravce a la méthode créée dans le repository
        $membresParBranche = $sectionRepository->membresParBranche();

        //récupérer le nom de tous les groupes d'unités pour les afficher sur une carte interactive et avoir accés à leur unité
        //que j'afficherai dans un popUp avec le nom des unités
        $groupeUnite= $entityManager->getRepository(WsGroupeUnite::class)->findAll();
        
       

       
        //calcul du pourcentage de membres 

        foreach ($membresParBranche as &$data) {
            $data['percentage'] = ($totalMembers > 0) ? round(($data['total'] / $totalMembers) * 100, 2) : 0;
        }

        return $this->render('dash_board/index.html.twig', [
            'totalMembres' => $totalMembers, //total membres
            'totalUnite' => $totalUnits, //total d'unité
            'totalGroupeUnite' => $totalGroups, //total de groupe d'unité
            'membresParBranche' => $membresParBranche, //le nombre de membres par branches pour les afficher en %
            'groupeUnite' => $groupeUnite, //les groupes d'unité
    
           

        ]);
    }
}

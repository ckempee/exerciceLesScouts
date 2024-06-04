<?php

namespace App\Controller;

use App\Entity\WsGroupeUnite;
use App\Entity\WsSection;
use App\Entity\WsUnite;
use App\Repository\WsSectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class WsGroupeUniteController extends AbstractController
{
    #[Route('/groupeUnite/{id}', name: 'uniteInGroupe', methods: ['GET', 'POST'])]
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

    #[Route('/groupeUnite/{id}/membresParBranche', name: 'membresParBranche', methods: ['GET'])]
    public function membresParBranche(WsUnite $unite, WsSectionRepository $sectionRepository): JsonResponse
    {
        $membresParBranche = $sectionRepository->membresParBrancheDansUnite($unite->getId());
        return new JsonResponse($membresParBranche);
    }

    #[Route('/test', name: 'membresParBranche', methods: ['GET'])]
    public function test(EntityManagerInterface $entityManager) : Response
    {
        $section= $entityManager->getRepository(WsSection::class)->findAll();
        return $this->render('test/index.html.twig', [
            "sections" => $section
        ]);
    }
}

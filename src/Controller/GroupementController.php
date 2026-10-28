<?php

namespace App\Controller;

use App\Entity\Groupement;
use App\Service\GroupementService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/groupements')]
class GroupementController extends AbstractController
{
    #[Route('', name: 'app_groupement_index', methods: ['GET'])]
    public function index(GroupementService $groupementService): Response
    {
        return $this->render('groupement/index.html.twig', [
            'groupements' => $groupementService->lister(),
        ]);
    }

    #[Route('/{id}', name: 'app_groupement_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Groupement $groupement): Response
    {
        return $this->render('groupement/show.html.twig', [
            'groupement' => $groupement,
        ]);
    }
}
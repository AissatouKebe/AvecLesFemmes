<?php

namespace App\Controller;

use App\Entity\Groupement;
use App\Service\GroupementService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Dto\GroupementFiltreDto;
use Symfony\Component\HttpFoundation\Request;

#[Route('/groupements')]
class GroupementController extends AbstractController
{
    #[Route('', name: 'app_groupement_index', methods: ['GET'])]
    public function index(Request $request, GroupementService $groupementService): Response
    {
        $filtre = new GroupementFiltreDto(
            ville: $request->query->get('ville'),
            tel: $request->query->get('tel'),
            page: $request->query->getInt('page', 1),
        );

        $pagination = $groupementService->lister($filtre);

        return $this->render('groupement/index.html.twig', [
            'groupements' => $pagination->items,   // ta boucle Twig ne change pas
            'pagination' => $pagination,
            'filtre' => $filtre,
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
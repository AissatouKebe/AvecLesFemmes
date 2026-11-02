<?php

namespace App\Controller;

use App\Entity\Groupement;
use App\Service\GroupementService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Dto\GroupementFiltreDto;
use Symfony\Component\HttpFoundation\Request;
use App\Dto\GroupementFormDto;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

        #[Route('/nouveau', name: 'app_groupement_new', methods: ['GET'])]
    public function new(): Response
    {
        return $this->render('groupement/new.html.twig');
    }

    #[Route('', name: 'app_groupement_create', methods: ['POST'])]
    public function create(Request $request, GroupementService $groupementService, ValidatorInterface $validator): JsonResponse
    {
        try {
            $donnees = $request->toArray();
        } catch (JsonException) {
            return $this->json(['erreurs' => ['_global' => 'Données invalides']], Response::HTTP_BAD_REQUEST);
        }

        $texte = fn(string $cle): string => is_string($donnees[$cle] ?? null) ? trim($donnees[$cle]) : '';

        $dto = new GroupementFormDto(
            nom: $texte('nom'),
            tel: $texte('tel'),
            adresse: $texte('adresse'),
        );

        $violations = $validator->validate($dto);
        if (count($violations) > 0) {
            $erreurs = [];
            foreach ($violations as $violation) {
                $erreurs[$violation->getPropertyPath()] = $violation->getMessage();
            }

            return $this->json(['erreurs' => $erreurs], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $groupementService->creer($dto);
        $this->addFlash('success', 'Groupement enregistré');

        return $this->json(['redirect' => $this->generateUrl('app_groupement_index')], Response::HTTP_CREATED);
    }
}
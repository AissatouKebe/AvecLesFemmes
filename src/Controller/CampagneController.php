<?php

namespace App\Controller;

use App\Service\CampagneService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/campagnes')]
class CampagneController extends AbstractController
{
    #[Route('', name: 'app_campagne_index', methods: ['GET'])]
    public function index(CampagneService $campagneService): Response
    {
        return $this->render('campagne/index.html.twig', [
            'campagnes' => $campagneService->lister(),
        ]);
    }
}
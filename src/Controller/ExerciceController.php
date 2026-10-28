<?php

namespace App\Controller;

use App\Service\ExerciceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/exercices')]
class ExerciceController extends AbstractController
{
    #[Route('', name: 'app_exercice_index', methods: ['GET'])]
    public function index(ExerciceService $exerciceService): Response
    {
        return $this->render('exercice/index.html.twig', [
            'exercices' => $exerciceService->lister(),
        ]);
    }
}
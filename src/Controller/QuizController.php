<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizController extends AbstractController
{
    #[Route('/quizzes', name: 'app_quizzes_add', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->json(['error' => true, 'message' => 'Ajax request required'], 400);
        }
        
        return $this->json();
    }
}

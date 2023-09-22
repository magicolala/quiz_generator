<?php

namespace App\Controller;

use App\Entity\QuizResult;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class QuizResultController extends AbstractController
{
    #[Route('/quiz/result/{id}', name: 'app_quiz_result')]
    public function index(?QuizResult $quizResult,  SerializerInterface $serializer): Response
    {
        if (!$quizResult) {
            return $this->redirectToRoute('app_home');
        }

        $data = ['results' => $quizResult->getResults(), 'quiz' => $quizResult->getQuiz()];
        $data = $serializer->serialize($data, 'json', ['groups' => ['quizResult']]);

        return $this->render('quiz_result/index.html.twig', [
            'quizResult' => $quizResult,
            'data' => $data
        ]);
    }
}

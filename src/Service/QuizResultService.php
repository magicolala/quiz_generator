<?php

namespace App\Service;

use App\Entity\Quiz;
use App\Entity\QuizResult;
use App\Repository\QuizResultRepository;

class QuizResultService
{
    public function __construct(
        private readonly QuizResultRepository $quizResultRepository,
    ) {
    }

    public function add(Quiz $quiz, array $quizResultData)
    {
        $quizResult = new QuizResult();
        $quizResult->setQuiz($quiz);
        $quizResult->setResults($quizResultData);

        $this->quizResultRepository->save($quizResult, true);

        return $quizResult;
    }
}

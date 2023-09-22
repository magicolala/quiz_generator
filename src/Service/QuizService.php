<?php

namespace App\Service;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Quiz;
use App\Repository\QuizRepository;
use Doctrine\ORM\EntityManagerInterface;

class QuizService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly QuizRepository $quizRepository,
    ) {
    }

    public function addQuiz(array $quizData, string $difficulty): Quiz
    {
        if (!isset($quizData['title']) || !isset($quizData['questions'])) {
            throw new \InvalidArgumentException("Invalid quiz data. 'title' and 'questions' are required.");
        }

        $quiz = new Quiz();
        $quiz->setTitle($quizData['title']);
        $quiz->setDifficulty($difficulty);

        foreach ($quizData['questions'] as $questionData) {

            $question = new Question();
            $question->setTitle($questionData['question']);
            $correctAnswer = $questionData['answer'];

            $this->em->persist($question);

            foreach ($questionData['answers'] as $key => $answerData) {
                if (!is_string($answerData)) {
                    throw new \InvalidArgumentException("Invalid answer data. 'answers' must be an array of strings.");
                }

                $answer = new Answer();
                $answer->setTitle($answerData);
                $answer->setIsCorrect($key === array_search($correctAnswer, $questionData['answers']));
                $question->addAnswer($answer);
                $this->em->persist($answer);
            }
            $quiz->addQuestion($question);
        }

        $this->quizRepository->save($quiz, true);

        return $quiz;
    }
}

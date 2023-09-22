<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Service\QuizResultService;
use App\Service\QuizService;
use OpenAI\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QuizController extends AbstractController
{
  #[Route('/quiz/{id}', name: 'app_quizzes_show', methods: ['GET', 'POST'])]
  public function showQuiz(?Quiz $quiz, Request $request, QuizResultService $quizResultService)
  {
    if (!$quiz) {
      return $this->redirectToRoute('app_home');
    }

    if ($request->isXMLHttpRequest() && $request->isMethod(Request::METHOD_POST)) {
      $body = json_decode($request->getContent(), true);

      if (!isset($body['quizResult'])) {
        return $this->json(['error' => true, 'message' => 'Missing quizResult'], 400);
      }

      $quizResult = $quizResultService->add($quiz, $body['quizResult']);

      return $this->json(['error' => false, 'quizResult' => ['id' => $quizResult->getId()]], 200);
    }


    return $this->render('quiz/show.html.twig', ['quiz' => $quiz]);
  }

  #[Route('/quizzes', name: 'app_quizzes_add', methods: ['POST'])]
  public function addQuiz(Client $client, QuizService $quizService, Request $request): JsonResponse
  {

    // Decode the JSON request body
    $body = json_decode($request->getContent(), true);

    // Check if the JSON decoding was successful
    if ($body === null && json_last_error() !== JSON_ERROR_NONE) {
      return $this->json(['error' => true, 'message' => 'Invalid JSON request body'], 400);
    }

    // Check if the request body is empty
    if (empty($body)) {
      return $this->json(['error' => true, 'message' => 'Empty request body'], 400);
    }

    try {
      // Throw an exception if the JSON decoding was unsuccessful
      if ($body === null && json_last_error() !== JSON_ERROR_NONE) {
        throw new \Exception('Invalid JSON request body');
      }
    } catch (\Exception $e) {
      return $this->json(['error' => true, 'message' => $e->getMessage()], 400);
    }

    if (!isset($body['content'])) {
      return $this->json(['error' => true, 'message' => 'Missing content']);
    }

    if (!isset($body['difficulty'])) {
      return $this->json(['error' => true, 'message' => 'Missing difficulty']);
    }

    // $content = "Rédige un quiz de niveau " . $body['difficulty'] . " de 20 questions avec un titre et 4 réponses par questions portant sur le sujet : " . $body['content'] . " au format JSON. Les propriétés utilisées sont 'answer', 'answers', 'question'.";

    // $content = $client->chat()->create([
    //   'model' => 'gpt-3.5-turbo',
    //   'messages' => ['content' => $content, 'role' => 'user']
    // ])['choices'][0]['message']['acontent'];

    $content = '{
      "title": "Êtes-vous un maître des échecs ? Testez vos connaissances sur ce jeu fascinant !",
      "questions": [
        {
          "question": "Quel est le nom du coup qui consiste à sacrifier une pièce pour obtenir un avantage positionnel ou matériel ?",
          "answers": [
            "Un gambit",
            "Un échec",
            "Une fourchette",
            "Une enfilade"
          ],
          "answer": "Un gambit"
        },
        {
          "question": "Quel est le nom de la variante d\'échecs où les pièces sont placées aléatoirement sur la première rangée ?",
          "answers": [
            "Les échecs aléatoires de Fischer",
            "Les échecs aléatoires de Capablanca",
            "Les échecs aléatoires de Morphy",
            "Les échecs aléatoires de Lasker"
          ],
          "answer": "Les échecs aléatoires de Fischer"
        },
        {
          "question": "Quel est le nom du joueur d\'échecs qui a battu Garry Kasparov en 1997 dans un match historique ?",
          "answers": [
            "Deep Blue",
            "AlphaZero",
            "Stockfish",
            "Komodo"
          ],
          "answer": "Deep Blue"
        },
        {
          "question": "Quel est le nom de la défense qui commence par les coups 1.e4 e5 2.Cf3 Cc6 3.Fb5 ?",
          "answers": [
            "La défense espagnole",
            "La défense française",
            "La défense sicilienne",
            "La défense caro-kann"
          ],
          "answer": "La défense espagnole"
        },
        {
          "question": "Quel est le nom de la pièce qui peut se déplacer en diagonale sur n\'importe quel nombre de cases ?",
          "answers": [
            "Le fou",
            "La tour",
            "Le cavalier",
            "Le pion"
          ],
          "answer": "Le fou"
        },
        {
          "question": "Quel est le nom du mouvement qui consiste à déplacer le roi de deux cases vers une tour, puis à placer la tour à côté du roi, de l\'autre côté ?",
          "answers": [
            "Le roque",
            "La promotion",
            "La prise en passant",
            "L\'échec et mat"
          ],
          "answer": "Le roque"
        },
        {
          "question": "Quel est le nom du joueur d\'échecs qui a été champion du monde pendant 27 ans, de 1894 à 1921 ?",
          "answers": [
            "Emanuel Lasker",
            "Wilhelm Steinitz",
            "José Raúl Capablanca",
            "Alexander Alekhine"
          ],
          "answer":
    "Emanuel Lasker"
        },
        {
          "question": "Quel est le nom du coup qui consiste à avancer un pion de deux cases, en passant devant un pion adverse qui aurait pu le capturer s\'il avait avancé d\'une seule case ?",
          "answers": [
            "L\'avance du pion dame",
            "L\'avance du pion roi",
            "L\'avance du pion central",
            "L\'avance du pion double"
          ],
          "answer": 
    "L\'avance du pion double"
        },
        {
          "question": 
    "Quel est le nom de la situation où un joueur ne peut pas faire de coup légal, mais son roi n\'est pas en échec ?",
         "answers":[
    "Le pat", 
    "Le nul", 
    "La nullité", 
    "La partie perdue"
    ],
    "answer":
    "Le pat"
    },
    {
    "question":
    "Quel est le nom de la notation qui utilise des lettres et des chiffres pour désigner les cases et les coups aux échecs ?",
    "answers":[
    "La notation algébrique", 
    "La notation descriptive", 
    "La notation figurine", 
    "La notation morse"
    ],
    "answer":
    "La notation algébrique"
    },
    {
    "question":
    "Quel est le nom du joueur d\'échecs qui a été le premier à obtenir un classement Elo supérieur à 2800 ?",
    "answers":[
    "Garry Kasparov", 
    "Magnus Carlsen", 
    "Bobby Fischer", 
    "Vladimir Kramnik"
    ],
    "answer":
    "Garry Kasparov"
    },
    {
    "question":
    "Quel est le nom de la pièce qui peut se déplacer en ligne droite sur n\'importe quel nombre de cases ?",
    "answers":[
    "La tour", 
    "Le fou", 
    "Le cavalier", 
    "Le pion"
    ],
    "answer":
    "La tour"
    },
    {
    "question":
    "Quel est le nom du coup qui consiste à transformer un pion qui atteint la dernière rangée en une autre pièce, généralement une dame ?",
    "answers":[
    "La promotion", 
    "La mutation", 
    "La conversion", 
    "L\'ascension"
    ],
    "answer":
    "La promotion"
    },
    {
    "question":
    "Quel est le nom de la variante d\'échecs où les joueurs ne voient pas l\'échiquier, mais doivent se souvenir des positions des pièces et annoncer leurs coups à voix haute ?",
    "answers":[
    "Les échecs à l\'aveugle", 
    "Les échecs à l\'oreille", 
    "Les échecs à la mémoire", 
    "Les échecs à l\'imagination"
    ],
    "answer":
    "Les échecs à l\'aveugle"
    },
    {
    "question":
    "Quel est le nom de la défense qui commence par les coups 1.e4 c5 ?",
    "answers":[
    "La défense sicilienne", 
    "La défense française", 
    "La défense scandinave", 
    "La défense hollandaise"
    ],
    "answer":
    "La défense sicilienne"
    },
    {
    "question":
    "Quel est le nom du joueur d\'échecs qui a été champion du monde pendant 20 ans, de 1975 à 1995 ?",
    "answers":[
    "Garry Kasparov", 
    "Magnus Carlsen", 
    "Bobby Fischer", 
    "Mikhail Botvinnik"
    ],
    "answer":
    "Garry Kasparov"
    },
    {
    "question":
    "Quel est le nom de la pièce qui peut se déplacer en forme de L, c\'est-à-dire deux cases dans une direction, puis une case perpendiculairement ?",
    "answers":[
    "Le cavalier", 
    "L\'éléphant", 
    "L\'archer", 
    "L\'aigle"
    ],
    "answer":
    "Le cavalier"
    },
    {
    "question":
    "Quel est le nom du coup qui consiste à capturer un pion adverse qui vient de se déplacer de deux cases, comme s\'il avait avancé d\'une seule case ?",
    "answers":[
    "La prise en passant", 
    "L\'enfilade", 
    "L\'épingle", 
    "L\'échange"
    ],
     "answer":
     "La prise en passant"
    },
    {
     "question":
     "Quel est le nom de la situation où un joueur met le roi adverse en échec de manière à ce qu\'il ne puisse pas s\'en sortir ?",
     "answers":[
     "L\'échec et mat", 
     "Le pat et mat", 
     "Le nul et mat", 
     "Le coup du berger"
     ],
     "answer":
     "L\'échec et mat"
    },
    {
     "question":
     "Quel est le nom du joueur d\'échecs qui a été champion du monde pendant 15 ans, de 1948 à 1963 ?",
     "answers":[
     "Mikhail Botvinnik", 
     "Anatoly Karpov", 
     "Vasily Smyslov", 
     "Tigran Petrosian"
     ],
     "answer":
     "Mikhail Botvinnik"
    }
    ]
    }';

    $quizData = json_decode($content, true);
    $difficulty = $body['difficulty'];

    $quiz = $quizService->addQuiz($quizData, $difficulty);

    return $this->json([
      'quiz' => $quiz->getId()
    ]);
  }
}

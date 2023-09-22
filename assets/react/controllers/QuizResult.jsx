import React from "react";
import {
  Container,
  TableContainer,
  Paper,
  TableCell,
  Table,
  TableHead,
  TableRow,
  TableBody,
  Chip,
  Rating,
  Typography,
} from "@mui/material";

export default function QuizResult(props) {
  const quizResult = JSON.parse(props.quizResult);
  const getQuestionTitle = (questionId) => {
    return questionId.title;
  };

  const findQuestionById = (id, quiz) =>
    quiz.questions.find((x) => x.id === id);
  const findAnswerById = (id, question) =>
    question.answers.find((x) => x.id === id);
  const findCorrectAnswer = (question) =>
    question.answers.find((x) => x.isCorrect);

  const getAnswerTitle = (result, quiz) => {
    const question = findQuestionById(result.questionId.id, quiz);
    const answer = findAnswerById(result.answerId, question);
    return answer.title;
  };

  const isCorrect = (result, quiz) => {
    const question = findQuestionById(result.questionId.id, quiz);
    const correctAnswer = findCorrectAnswer(question);
    return result.answerId === correctAnswer.id;
  };

  const score = quizResult.results.filter((result) =>
    isCorrect(result, quizResult.quiz)
  ).length;

  return (
    <Container>
      <div className="score-section" style={{ marginY: 5 }}>
        <Typography
          variant="h6"
          align="center"
        >{`Vous avez ${score} bonnes réponses sur ${quizResult.quiz.questions.length}`}</Typography>
        <div align="center">
          {" "}
          <Rating
            name="quiz-score"
            value={score}
            max={quizResult.quiz.questions.length}
            readOnly
            align="center"
          />
        </div>
      </div>
      <TableContainer component={Paper}>
        <Table>
          <TableHead>
            <TableRow>
              <TableCell>Question</TableCell>
              <TableCell>Réponse</TableCell>
              <TableCell>Etat</TableCell>
            </TableRow>
          </TableHead>

          <TableBody>
            {quizResult.results.map((result) => (
              <TableRow key={result.questionId.id}>
                <TableCell>{getQuestionTitle(result.questionId)}</TableCell>
                <TableCell>{getAnswerTitle(result, quizResult.quiz)}</TableCell>
                <TableCell>
                  <Chip
                    color={
                      isCorrect(result, quizResult.quiz) ? "success" : "error"
                    }
                    label={
                      isCorrect(result, quizResult.quiz)
                        ? "Bonne réponse"
                        : "Mauvaise réponse"
                    }
                  ></Chip>
                </TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </TableContainer>
    </Container>
  );
}

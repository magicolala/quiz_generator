import React from "react";
import { Container, MobileStepper, Button, Typography } from "@mui/material";
import Question from "./Question";

export default function Quiz(props) {
  const quiz = JSON.parse(props.quiz);
  const [activeStep, setActiveStep] = React.useState(0);
  const [quizResult, setQuizResult] = React.useState([]);
  const isLastQuestion = () => {
    return activeStep === quiz.questions.length - 1;
  };
  const handleNextQuestion = async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    quizResult.push({
      questionId: quiz.questions[activeStep],
      answerId: parseInt(formData.get("answer")),
    });

    if (!isLastQuestion()) {
      setActiveStep((prevActiveStep) => prevActiveStep + 1);
      return;
    }
    console.log(quiz);
    // Si valider
    const response = await fetch("/quiz/" + quiz.id, {
      body: JSON.stringify({ quizResult: quizResult }),
      method: "POST",
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
    });
    const json = await response.json();
    window.location.href = "/quiz/result/" + json.quizResult.id;
  };

  return (
    <Container maxWidth="sm">
      <Typography variant="h3" textAlign="center" gutterBottom>
        {quiz.title}
      </Typography>
      <form onSubmit={handleNextQuestion}>
        <Question question={quiz.questions[activeStep]}></Question>
        <div style={{ marginTop: 10, textAlign: "center" }}>
          <Button type="submit" style={{ marginTop: 20 }} variant="outlined">
            {isLastQuestion() ? "Terminer" : "Suivant"}
          </Button>
        </div>
      </form>
      <MobileStepper
        backButton={<Button style={{ visibility: "hidden" }}></Button>}
        nextButton={<Button style={{ visibility: "hidden" }}></Button>}
        steps={quiz.questions.length}
        activeStep={activeStep}
        position="static"
        variant="dots"
        style={{ marginTop: 10 }}
      ></MobileStepper>
    </Container>
  );
}

import React, { useState } from "react";
import {
  Container,
  Grid,
  TextField,
  Typography,
  Card,
  Button,
  CircularProgress,
  Select,
  MenuItem,
  List,
  ListItem,
  ListItemText,
} from "@mui/material";
import { makeStyles } from "@mui/styles";

const useStyles = makeStyles({
  container: {
    display: "flex",
    justifyContent: "center",
    alignItems: "center",
  },
  card: {
    padding: "20px",
    borderRadius: "10px",
    boxShadow: "0px 14px 28px rgba(0,0,0,0.25)",
  },
});

export default function CreateQuiz(props) {
  const classes = useStyles();
  const [generating, setGenerating] = useState(false);
  const [difficulty, setDifficulty] = useState("facile");
  const quizzes = JSON.parse(props.quizzes);

  const createQuiz = async (content) => {
    const response = await fetch("/quizzes", {
      method: "POST",
      body: JSON.stringify({ content, difficulty }),
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
    });
    setGenerating(false);
    const json = await response.json();

    return json.quiz;
  };

  const handleSubmit = async (event) => {
    event.preventDefault();
    setGenerating(true);
    const formData = new FormData(event.target);
    const content = formData.get("content");
    const quizId = await createQuiz(content);

    window.location.href = "/quiz/" + quizId;
  };

  return (
    <Container className={classes.container}>
      <Grid container spacing={3} marginY={1.5}>
        <Grid item xs={6}>
          <Card className={`text-center ${classes.card}`}>
            <Typography variant="h3" fontWeight="bold" marginY={1}>
              Make My Quiz
            </Typography>
            <form onSubmit={handleSubmit}>
              <TextField fullWidth label="Générer un quizz" name="content" />
              <Select
                fullWidth
                label="Difficulté"
                name="difficulty"
                value={difficulty}
                onChange={(event) => setDifficulty(event.target.value)}
                style={{ marginTop: 10 }}
              >
                <MenuItem value="facile">Facile</MenuItem>
                <MenuItem value="moyen">Moyen</MenuItem>
                <MenuItem value="difficile">Difficile</MenuItem>
              </Select>
              <Button
                variant="outlined"
                disabled={generating}
                fullWidth
                style={{ marginTop: 20 }}
                type="submit"
              >
                {generating ? (
                  <CircularProgress color="secondary" size={24} />
                ) : (
                  "Générer"
                )}
              </Button>
            </form>
          </Card>
        </Grid>
        <Grid item xs={6}>
          <Card className={`text-center ${classes.card}`}>
            <Typography
              className="text-center"
              variant="h3"
              fontWeight="bold"
              marginY={1}
            >
              Liste des quiz
            </Typography>
            <hr />
            <List>
              {quizzes.map((quiz) => (
                <ListItem
                  key={quiz.id}
                  button
                  component="a"
                  href={`/quiz/${quiz.id}`}
                >
                  <ListItemText
                    primary={quiz.title}
                    secondary={quiz.difficulty}
                  />
                </ListItem>
              ))}
            </List>
          </Card>
        </Grid>
      </Grid>
    </Container>
  );
}

import {
  Container,
  Grid,
  TextField,
  Typography,
  Card,
  Button,
} from "@mui/material";
import React from "react";

export default function CreateQuiz() {
  return (
    <Container maxWidth="sm">
      <Grid
        container
        direction="row"
        justifyContent="center"
        alignItems="center"
      >
        <Grid item>
          <Typography component="h2" variant="h2" fontWeight="bold" marginY={5}>
            Make My Quiz
          </Typography>
        </Grid>
        <Grid item>
          <Card style={{ padding: 15 }}>
            <form>
              <TextField
                fullWidth
                label="Générer un quizz"
                name="content"
              ></TextField>
              <Button
                variant="outlined"
                fullWidth
                style={{ marginTop: 20 }}
                type="submit"
              >
                Générer
              </Button>
            </form>
          </Card>
        </Grid>
      </Grid>
    </Container>
  );
}

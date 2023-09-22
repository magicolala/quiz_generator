import React from "react";
import {
  Card,
  CardContent,
  Typography,
  FormControl,
  RadioGroup,
  FormControlLabel,
  Radio,
} from "@mui/material";

export default function Question(props) {
  return (
    <Card variant="outlined" style={{ marginY: 30 }}>
      <CardContent>
        <Typography
          fontWeight="bold"
          component="div"
          gutterBottom
          variant="h5"
          textAlign="center"
        >
          {props.question.title}
        </Typography>
        <hr></hr>
        <FormControl>
          <RadioGroup name="answer">
            {props.question.answers.map((answer) => (
              <FormControlLabel
                key={answer.id}
                control={<Radio />}
                label={answer.title}
                value={answer.id}
              ></FormControlLabel>
            ))}
          </RadioGroup>
        </FormControl>
      </CardContent>
    </Card>
  );
}

<?php

if (isset($_POST['submit'])) {
    $answer = $_POST['answer'];
    $answerkey = $_POST['answerkey'];
    $quizID = $_POST['question_id'];

    echo "Your answer is $answer";
    //checking if the input answer is not empty......
    if ($answer == "") {
        echo "no answer read";
        //all good........    
    } else {
        //if answer is correct.......
        if ($answer == $answerkey) {

            //scoring criteria......
       //   if ($totalMistakes == 0) {
          //      $score = 5;
           // } else if ($totalMistakes == 1) {
            //    $score = 4;
          //  } else if ($totalMistakes == 2) {
            //     $score = 3;
            // } else if ($totalMistakes == 3) {
            //     $score = 2;
            // } else if ($totalMistakes == 4) {
            //     $score = 1;
            // } else {
            //     $score = 0;
            // }
            // $totalScore = $score;
            // query for inserting score to exam_correct table database.............
            // $saveScore = "INSERT INTO `quiz_correct`(`user_id`, `quiz_id`, `quizItemID`, `points`, `hint_used`, `quiz_attempt`) 
            // VALUES ('[value-2]',$quizID,'[value-4]','[value-5]','[value-6]','[value-7]')";

            // $scorequery = "INSERT INTO `exam_correct`(`student_id`, `exam_id`, `examitem_id`, `points`,`hint_attempt`,`exam_attempt`) 
            // VALUES ($studentID,$examID,$questionId,$totalScore,$hintUseValue,$examAttempt)";
            // $result = mysqli_query($con, $scorequery);
        }
    }
}

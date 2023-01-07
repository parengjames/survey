<?php
session_start();
include('db_connect.php');
if (isset($_POST['submit'])) {
    $answer = $_POST['answer'];
    $answerkey = $_POST['answerkey'];
    $quizitemID = $_POST['question_id'];
    $quiz_id = $_SESSION['quiz-id'];
    $mistakes = 1;
    //user....
    $user_id = $_SESSION['login_id'];
    // quiz attempt.....
    $quizAttempt = $_SESSION['quiz_attempt'];

    $currentItem =  $_SESSION['itemNum'];

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
        // got wrong answer........
        else{
            $mistakequery = "INSERT INTO `quiz_mistake`(`user_id`, `quizItem_id`, `quiz_id`, `input_answer`, `mistake`, `quiz_attempt`) 
            VALUES($user_id,$quizitemID,$quiz_id,$answer,$mistakes,$quizAttempt)";
             $insertResult = mysqli_query($conn, $mistakequery);

             // fetching mistakes from database........
             $fetchquery = "SELECT SUM(mistake) AS totalmistakes FROM quiz_mistake
             WHERE user_id=$user_id AND quizItem_id=$quizitemID AND quiz_attempt=$quizAttempt";
             $queryResult = mysqli_query($conn, $fetchquery);
             $rowCount = mysqli_num_rows($queryResult);

             if($rowCount > 0){
                $record = mysqli_fetch_assoc($queryResult);
                while($record){
                    $mistakes = $record['totalmistakes'];
                    if($mistakes == 1){
                        $_SESSION['headertext'] = "Try again";
                        $_SESSION['bodytext']   = "Answer is wrong";
                        $_SESSION['statusIcon'] = "error";
                        header("location: ../survey/quiz_lesson1.php?repeat=1&question=$currentItem");
                    }
                    break;
                }
             }
        }
    }
}

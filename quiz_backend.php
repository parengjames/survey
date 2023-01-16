<?php
session_start();
include('db_connect.php');
if (isset($_POST['submit'])) {
    $answer = $_POST['answer'];
    $answerkey = $_POST['answerkey'];
    $hintUseValue = $_POST['hintusage'];
    $HintDisplay = $_POST['hintdisplay'];
    $quizitemID = $_POST['question_id'];
    $quiz_id = $_SESSION['quiz-id'];
    $mistakes = 1;
    //user....
    $user_id = $_SESSION['login_id'];
    // quiz attempt.....
    $quizAttempt = $_SESSION['quiz_attempt'];

    $currentItem =  $_SESSION['itemNum'];

    $over = $_SESSION['over'];
    //checking if the input answer is not empty......
    if ($answer == "") {
        $_SESSION['headertext_empty'] = "No answer detected";
        $_SESSION['bodytext_empty']   = "Make sure to click the choices to submit the answer.";
        $_SESSION['statusIcon_empty'] = "warning";
        header("location: ../survey/quiz_lesson1.php?repeat=$over&question=$currentItem");
        //all good........    
    } else {
        //if answer is correct.......
        if ($answer == $answerkey) {
            $totalMistakes = $_SESSION['over'];
            $numberofItem = $_SESSION['totalquestion'];
            //scoring criteria......
            if ($totalMistakes == 0) {
                $score = 5;
            } else if ($totalMistakes == 1) {
                $score = 4;
            } else if ($totalMistakes == 2) {
                $score = 3;
            } else if ($totalMistakes == 3) {
                $score = 2;
            } else if ($totalMistakes == 4) {
                $score = 1;
            } else {
                $score = 0;
            }
            $totalScore = $score;
            // query for inserting score to exam_correct table database.............
            $saveScore = "INSERT INTO `quiz_correct`(`user_id`, `quiz_id`, `quizItemID`, `points`, `hint_used`, `quiz_attempt`) 
            VALUES ($user_id,$quiz_id,$quizitemID,$totalScore,$hintUseValue,$quizAttempt)";
            $insertResult = mysqli_query($conn, $saveScore);

            $itemIncrement = $_SESSION['itemNum'];
            $itemstay = $_SESSION['itemNum'];
            $_SESSION['stay'] = $itemstay;

            // reach the last question............
            if($itemIncrement == $numberofItem){
                $_SESSION['headertextlast'] = "Nice! that's correct one";
                $_SESSION['bodytextlast']   = "This is last question. See the result now. Correct answer is " . $answerkey . " and score obtained " . $totalScore . " points";
                $_SESSION['statusIconlast'] = "success";
                header("location: ../survey/quiz_lesson1.php?question=$numberofItem");
            }else{
                ++$itemIncrement;
                $_SESSION['nextitem'] = $itemIncrement;
                $_SESSION['headertextitem'] = "Nice! that's correct one";
                $_SESSION['bodytextitem']   = "The answer of that question is " . $answerkey . " and you've got " . $totalScore . " points";
                $_SESSION['ItemStatus'] = 'success';
                header("location: ../survey/quiz_lesson1.php?checkpoint=1&question=$itemstay");
            }
        }
        // got wrong answer........
        else {
            $mistakequery = "INSERT INTO `quiz_mistake`(`user_id`, `quizItem_id`, `quiz_id`, `input_answer`, `mistake`, `quiz_attempt`) 
            VALUES($user_id,$quizitemID,$quiz_id,'". $answer ."',$mistakes,$quizAttempt)";
            $insertResult = mysqli_query($conn, $mistakequery);

            // fetching mistakes from database........
            $fetchquery = "SELECT SUM(mistake) AS totalmistakes FROM quiz_mistake
             WHERE user_id=$user_id AND quizItem_id=$quizitemID AND quiz_attempt=$quizAttempt";
            $queryResult = mysqli_query($conn, $fetchquery);
            $rowCount = mysqli_num_rows($queryResult);

            if ($rowCount > 0) {
                $record = mysqli_fetch_assoc($queryResult);
                while ($record) {
                    $mistakes = $record['totalmistakes'];
                    if ($mistakes == 1) {
                        $_SESSION['headertext'] = "Try again";
                        $_SESSION['bodytext']   = "The answer is wrong";
                        $_SESSION['statusIcon'] = "error";
                        header("location: ../survey/quiz_lesson1.php?repeat=1&question=$currentItem");
                    } else if ($mistakes == 2) {
                        $_SESSION['headertext'] = "Try again";
                        $_SESSION['bodytext']   = "Answer is wrong, analyze the question carefully.";
                        $_SESSION['statusIcon'] = "error";
                        header("location: ../survey/quiz_lesson1.php?repeat=2&question=$currentItem");
                    } else if ($mistakes == 3) {
                        $_SESSION['headertext'] = "Try again, Still wrong answer";
                        $_SESSION['bodytext']   = "SETI suggest, you can use the hint now";
                        $_SESSION['statusIcon'] = "warning";
                        header("location: ../survey/quiz_lesson1.php?repeat=3&question=$currentItem");
                    } else if ($mistakes == 4) {
                        $_SESSION['headertext'] = "Still wrong answer";
                        $_SESSION['bodytext']   = "SETI suggest, you can use the hint now for more idea";
                        $_SESSION['statusIcon'] = "warning";
                        header("location: ../survey/quiz_lesson1.php?repeat=4&question=$currentItem&usehint=$hintUseValue&display=$HintDisplay");
                    } else {
                        ++$over;
                        $_SESSION['headertext'] = "Still wrong answer";
                        $_SESSION['bodytext']   = "SETI suggest that you can use the HINT for more idea.";
                        $_SESSION['statusIcon'] = "error";
                        header("location: ../survey/quiz_lesson1.php?repeat=$over&question=$currentItem&usehint=$hintUseValue&display=$HintDisplay");
                    }
                    break;
                }
            } else {
                echo "no record found......";
            }
        }
    }
}

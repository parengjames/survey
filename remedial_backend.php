<?php

session_start();
include('db_connect.php');

if(isset($_POST['submit'])){
    $answer = $_POST['answer'];
    $answerkey = $_POST['answerkey'];
    $quizitemID = $_POST['question_id'];
    $hintUseValue = $_POST['hintusage'];
    $HintDisplay = $_POST['hintdisplay'];
    $firstItem = $_POST['itemincrement'];

    $quiz_id = $_SESSION['quiz-id'];
    $user_id = $_SESSION['login_id'];
    $quizAttempt = $_SESSION['quiz_attempt'];
    $currentItem =  $_SESSION['itemNum'];
    $currentquest = $_SESSION['current_item'];
    $over = $_SESSION['over'];

    $mistakes = 1;

    //checking if the input answer is not empty......
    if ($answer == "") {
        $_SESSION['headertext_empty'] = "No answer detected";
        $_SESSION['bodytext_empty']   = "Make sure to click the choices to submit the answer.";
        $_SESSION['statusIcon_empty'] = "warning";
        header("location: ../survey/remedial_quiz.php?repeat=$over&question=$currentItem&num=$currentquest");
    }else{
        //if answer is correct.......
        if ($answer == $answerkey) {
            $numberofitems = $_SESSION['rem_totalquestion'];
            $totalmistake = $over;
            //scoring criteria......
            if ($totalmistake == 0) {
                $score = 1;
            } else if ($totalmistake == 1) {
                $score = 0;
            } else {
                $score = 0;
            }
            $Item_check = $score;
            // query for inserting score to exam_correct table database.............
            $saveScore = "INSERT INTO `retake_correct`(`user_id`, `quiz_id`, `quizItem_id`, `hint_used`,`num_check`, `retake_attempt`) 
            VALUES ($user_id,$quiz_id,$quizitemID,$hintUseValue,$Item_check,$quizAttempt)";
            $insertResult = mysqli_query($conn, $saveScore);

            $itemIncrement = $_SESSION['itemNum'];
            $itemstay = $_SESSION['itemNum'];
            $_SESSION['stay'] = $itemstay;
            $itemnext = $_SESSION['current_item'];
            $quesstay = $_SESSION['current_item'];

            // reach the last question............
            if($itemIncrement == $numberofitems){
                $_SESSION['headertextlast'] = "Nice! that's correct one";
                $_SESSION['bodytextlast']   = "This is last question. See the result now. Correct answer is " . $answerkey . "";
                $_SESSION['statusIconlast'] = "success";
                header("location: ../survey/remedial_quiz.php?question=$numberofitems&num=$quesstay");
            }else{
                ++$itemIncrement;
                ++$itemnext;
                $_SESSION['nextitem'] = $itemIncrement;
                $_SESSION['item-next'] = $itemnext;
                $_SESSION['first-item'] = $firstItem;
                $_SESSION['headertextitem'] = "Nice! that's correct one";
                $_SESSION['bodytextitem']   = "The answer of that question is " . $answerkey . "";
                $_SESSION['ItemStatus'] = 'success';
                header("location: ../survey/remedial_quiz.php?checkpoint=1&question=$itemstay&num=$quesstay");
            }

        }
        // got wrong answer........
        else {
            $mistakequery = "INSERT INTO `retake_mistake`(`user_id`, `quizItem_id`, `quiz_id`, `input_answer`, `mistake`, `retake_attempt`) 
            VALUES ($user_id,$quizitemID,$quiz_id,'". $answer ."',$mistakes,$quizAttempt)";
            $insertResult = mysqli_query($conn, $mistakequery);

            // fetching mistakes from database........
            $fetchquery = "SELECT SUM(mistake) AS totalmistakes FROM retake_mistake
             WHERE user_id=$user_id AND quizItem_id=$quizitemID AND retake_attempt=$quizAttempt";
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
                        header("location: ../survey/remedial_quiz.php?repeat=1&question=$currentItem&num=$currentquest");
                    } else if ($mistakes == 2) {
                        $_SESSION['headertext'] = "Try again";
                        $_SESSION['bodytext']   = "SETI suggest, you can use the hint now";
                        $_SESSION['statusIcon'] = "error";
                        header("location: ../survey/remedial_quiz.php?repeat=2&question=$currentItem&num=$currentquest");
                    } else if ($mistakes == 3) {
                        $_SESSION['headertext'] = "Try again, Still wrong answer";
                        $_SESSION['bodytext']   = "SETI suggest, you can use the hint now";
                        $_SESSION['statusIcon'] = "warning";
                        header("location: ../survey/remedial_quiz.php?repeat=3&question=$currentItem&num=$currentquest");
                    } else if ($mistakes == 4) {
                        $_SESSION['headertext'] = "Still wrong answer";
                        $_SESSION['bodytext']   = "SETI suggest, you can use the hint now for more idea";
                        $_SESSION['statusIcon'] = "warning";
                        header("location: ../survey/remedial_quiz.php?repeat=4&question=$currentItem&num=$currentquest&usehint=$hintUseValue&display=$HintDisplay");
                    } else {
                        ++$over;
                        $_SESSION['headertext'] = "Still wrong answer";
                        $_SESSION['bodytext']   = "SETI suggest that you can use the HINT for more idea.";
                        $_SESSION['statusIcon'] = "error";
                        header("location: ../survey/remedial_quiz.php?repeat=$over&question=$currentItem&num=$currentquest&usehint=$hintUseValue&display=$HintDisplay");
                    }
                    break;
                }
            }
        }

    }

}

?>
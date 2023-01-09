<!DOCTYPE html>
<html lang="en">

<head>
</head>

<?php include('header.php') ?>

<?php include('db_connect.php');

?>
<!-- SCRIPT FOR SWEETALERT -->
<script src="assets/plugins/sweetalert2/sweetalert.min.js"></script>
<script src="assets/plugins/sweetalert2/jquery-3.6.1.min.js"></script>

<title>Take Quiz</title>
</head>

<?php
$userID = $_SESSION['login_id'];
$quizID = $_SESSION['quiz-id'];
$attempt = $_SESSION['quizAttempt'];
?>

<body>
    <div class="container-fluid admin">
        <div class="col-md-12 alert alert-primary">Your Quiz Result</div>
        <br>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <table class="table table-bordered" id='table'>
                            <tbody>
                                <tr>
                                    <th style="font-size: 20px;font-weight: bolder;">Your Total Score: </th>
                                    <?php
                                    $totalScorequery = "SELECT SUM(points)AS stud_totalpoints FROM quiz_correct
                                            WHERE `user_id`=$userID AND quiz_attempt=$attempt AND quiz_id=$quizID";
                                    $queryResult = mysqli_query($conn, $totalScorequery);
                                    $rowCount = mysqli_num_rows($queryResult);
                                    if ($rowCount > 0) {
                                        $record = mysqli_fetch_assoc($queryResult);
                                        while ($record) {
                                            $studtotalScore = $record['stud_totalpoints'];
                                            break;
                                        }
                                    }
                                    if ($studtotalScore >= $_SESSION['passingscore']) {
                                    ?>
                                        <td style="font-size: 20px;font-weight: bolder;color: #32CD32;text-align: center;"><?php echo $studtotalScore; ?></td>
                                    <?php
                                    } else {
                                    ?>
                                        <td style="font-size: 20px;font-weight: bolder;color: #FF0000;text-align: center;"><?php echo $studtotalScore; ?></td>
                                    <?php
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <th>Quiz total Score: </th>
                                    <td style="text-align: center;">
                                        <?php $quiztotalpoints = $_SESSION['totalpoints'];
                                        echo $quiztotalpoints; ?></td>
                                </tr>
                                <tr>
                                    <th>Total Mistakes: </th>
                                    <?php
                                    $totalmis_query = "SELECT COUNT(mistake)AS totalmistakes FROM `quiz_mistake` 
                                    WHERE `user_id`=$userID AND quiz_id=$quizID AND quiz_attempt=$attempt";
                                    $queryResult = mysqli_query($conn, $totalmis_query);
                                    $rowCount = mysqli_num_rows($queryResult);
                                    if ($rowCount > 0) {
                                        $record = mysqli_fetch_assoc($queryResult);
                                        while ($record) {
                                            $studtotalmistake = $record['totalmistakes'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <td style="text-align: center;color: #FF0000;"><?php echo $studtotalmistake; ?></td>
                                </tr>
                                <tr>
                                    <th>Number of Hint used: </th>
                                    <?php
                                    $totalhint_query = "SELECT SUM(hint_used)AS totalhintused FROM quiz_correct
                                    WHERE `user_id`=$userID AND quiz_id=$quizID AND quiz_attempt=$attempt";
                                    $queryResult = mysqli_query($conn, $totalhint_query);
                                    $rowCount = mysqli_num_rows($queryResult);
                                    if ($rowCount > 0) {
                                        $record = mysqli_fetch_assoc($queryResult);
                                        while ($record) {
                                            $studtotalhint = $record['totalhintused'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <td style="text-align: center;"><?php echo $studtotalhint; ?></td>
                                </tr>
                                <tr>
                                    <th>Passing Score: </th>
                                    <td style="text-align: center;">
                                        <?php $passinggrades = $_SESSION['passingscore'];
                                        echo $passinggrades; ?></td>
                                </tr>
                                <tr>
                                    <th>Total Question: </th>
                                    <td style="text-align: center;">
                                        <?php $quiztotalitem =  $_SESSION['totalquestion'];
                                        echo $quiztotalitem; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <table style="text-align: center;" class="table" id='table'>
                            <thead>
                                <th style="font-size: 25px;">Remarks</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    $ispassed;
                                    if ($studtotalScore >= $passinggrades) {
                                        $ispassed = 1;

                                    ?>
                                        <td style="color: #32CD32;">
                                            <h2 style="font-weight: bolder;">Quiz Passed</h2>        
                                        </td>
                                    <?php
                                    }else{
                                        $ispassed = 0;
                                        ?>
                                        <td style="color: #FF0000;">
                                            <h2 style="font-weight: bolder;">Quiz Failed</h2>  
                                            <span>Don't worry you can take the quiz again.</span>      
                                        </td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
<!-- INITIALIZING THE QUIZ ATTEMPT.... -->
<?php
// $stud_quiz_attempt;
// if(isset($_SESSION['stud_totalAttempt'])){
// 	$stud_quiz_attempt = $_SESSION['stud_totalAttempt'];
// }else{
// 	$student_id = $_SESSION['login_id'];
// 	$sqlgetquery = "SELECT MAX(status)AS getAttempt FROM quiz_attempt
// 	WHERE student_id=$student_id AND quiz_id=$quizid";
// 	$queryResult = mysqli_query($conn, $sqlgetquery);
//     $rowCount = mysqli_num_rows($queryResult);
// 	if ($rowCount > 0) {
//         $record = mysqli_fetch_assoc($queryResult);
//         while ($record) {
//             if ($record['getAttempt'] == 0) {
//                 $stud_quiz_attempt = 1;
//             } else {
//                 $stud_quiz_attempt = ++$record['getAttempt'];
//             }
//             $record = mysqli_fetch_assoc($queryResult);
//         }
//     }
// }
?>
</html>

<!-- INPUT RESULT RECORD TO DATABASE -->
<?php
if (isset($_GET['saveResult'])) {
    $insertResultquery = "INSERT INTO `quiz_result`(`user_id`, `quiz_id`, `total_wrong`, `total_hint`, `final_score`, `is_passed`, `quiz_attempt`) 
    VALUES ($userID,$quizID,$studtotalmistake,$studtotalhint,$studtotalScore,$ispassed,$attempt)";
    $insertResult = mysqli_query($conn, $insertResultquery);
}
?>
<?php
if (isset($_GET['saveResult'])) {
?>
    <script>
        swal({
            title: "You've finish the quiz",
            text: "Good job, See your result now.",
            icon: 'success',
            button: 'OK'
        }).then(function() {
            window.location = "index.php?page=quiz_result";
        });
    </script>
<?php
}
?>
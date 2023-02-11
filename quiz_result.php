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

<title>Quiz Result</title>
</head>



<?php
$userID = $_SESSION['login_id'];
$quizID = $_SESSION['quiz-id'];
$attempt = $_SESSION['quizAttempt'];
?>

<!-- Calculate the quiz duration -->
<?php
$query1 = mysqli_query($conn, "SELECT * FROM `quiz_attempt` WHERE student_id = $userID and status = $attempt");
$rowcount = mysqli_num_rows($query1);
if ($rowCount > 0) {
    while ($row = mysqli_fetch_assoc($query1)) {
        $starttime = strtotime($row['date']);
        //--------------
        $query2 = mysqli_query($conn, "SELECT * FROM `quiz_result` WHERE `user_id` = $userID and quiz_attempt = $attempt");
        $rowcount = mysqli_num_rows($query2);
        if ($rowCount > 0) {
            while ($row1 = mysqli_fetch_assoc($query2)) {
                $endtime = strtotime($row1['date_saved']);

                // calculate the minutes duration......
                $minute = ($endtime - $starttime) / 60;
                $formatted_time = number_format($minute);

                $updatequery = "UPDATE `quiz_result` SET `time_duration`=$formatted_time WHERE `user_id` = $userID and quiz_id = $quizID and quiz_attempt = $attempt";
                $updateResult = mysqli_query($conn, $updatequery);
            }
        }
    }
}

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
                                    <th>Time duration: </th>
                                    <?php
                                    $duration_query = "SELECT * FROM `quiz_result` 
                                    WHERE `user_id` = $userID and quiz_id = $quizID and quiz_attempt = $attempt";
                                    $queryResult = mysqli_query($conn, $duration_query);
                                    $rowCount = mysqli_num_rows($queryResult);
                                    if ($rowCount > 0) {
                                        $record = mysqli_fetch_assoc($queryResult);
                                        while ($record) {
                                            $timeduration = $record['time_duration'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <td style="text-align: center;">
                                        <?php echo $timeduration . " min"; ?></td>
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
                                    } else {
                                        $ispassed = 0;
                                    ?>
                                        <td style="color: #FF0000;">
                                            <h2 style="font-weight: bolder;">Quiz Failed</h2>
                                            <span>Don't worry you can take the quiz again. Seti suggest that you need to read and study more about the topic.</span>
                                            <br><br>
                                            <a class="btn btn-primary" href="index.php?page=module">
                                                Go to module
                                            </a>
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

</html>



<!-- INPUT RESULT RECORD TO DATABASE -->
<?php
if (isset($_GET['saveResult'])) {
    // INPUT RESULT RECORD TO DATABASE
    $insertResultquery = "INSERT INTO `quiz_result`(`user_id`, `quiz_id`, `total_wrong`, `total_hint`, `final_score`, `is_passed`, `quiz_attempt`) 
    VALUES ($userID,$quizID,$studtotalmistake,$studtotalhint,$studtotalScore,$ispassed,$attempt)";
    $insertResult = mysqli_query($conn, $insertResultquery);

    // Identify the attempt that failed........
    $retakeQuery = mysqli_query($conn, "SELECT COUNT(quiz_attempt) AS num_items FROM `item_retake` 
        WHERE quiz_attempt = $attempt");
    $rowcount = mysqli_num_rows($retakeQuery);
    if ($rowcount > 0) {
        while ($row = mysqli_fetch_assoc($retakeQuery)) {
            $numberofItems = $row['num_items'];
            if ($numberofItems >= 5) {
                $passretake = "INSERT INTO `quiz_retake`(`quiz_id`, `user_id`, `quiz_attempt`, `num_items`) 
                    VALUES ($quizID,$userID,$attempt,$numberofItems)";
                $insertResult = mysqli_query($conn, $passretake);
            }
        }
    }
}
?>
<?php
if (isset($_GET['saveResult'])) {
?>
    <script>
        swal({
            title: "You've finish the quiz",
            text: " See your result now.",
            icon: 'success',
            button: 'OK'
        }).then(function() {
            window.location = "index.php?page=quiz_result";
        });
    </script>
<?php
}
?>
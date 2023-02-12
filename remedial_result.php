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

<title>Remedial quiz Result</title>
</head>



<?php
$userID = $_SESSION['login_id'];
$quizID = $_SESSION['quiz-id'];
$attempt = $_SESSION['quiz_attempt']
?>

<!-- Calculate the quiz duration -->
<?php
$query1 = mysqli_query($conn, "SELECT * FROM `retake_attempt` WHERE student_id = $userID and status = $attempt");
$rowcount = mysqli_num_rows($query1);
if ($rowCount > 0) {
    while ($row = mysqli_fetch_assoc($query1)) {
        $starttime = strtotime($row['date_saved']);
        //--------------
        $query2 = mysqli_query($conn, "SELECT * FROM `retake_result` WHERE `user_id` = $userID and retake_attempt = $attempt");
        $rowcount = mysqli_num_rows($query2);
        if ($rowCount > 0) {
            while ($row1 = mysqli_fetch_assoc($query2)) {
                $endtime = strtotime($row1['date_saved']);

                // calculate the minutes duration......
                $minute = ($endtime - $starttime) / 60;
                $formatted_time = number_format($minute);

                $updatequery = "UPDATE `retake_result` SET `duration`=$formatted_time WHERE `user_id` = $userID and quiz_id = $quizID and retake_attempt = $attempt";
                $updateResult = mysqli_query($conn, $updatequery);
            }
        }
    }
}

?>

<body>
    <div class="container-fluid admin">
        <div class="col-md-12 alert alert-primary">Your Remedial Quiz Result</div>
        <br>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id='table' style="width: 600px;margin: auto;">
                    <tbody>
                        <tr>
                            <th style="font-size: 20px;font-weight: bolder;">Your Total Correct: </th>
                            <?php
                            $totalScorequery = "SELECT SUM(num_check)AS stud_totalpoints FROM retake_correct
                                            WHERE `user_id`=$userID AND retake_attempt=$attempt AND quiz_id=$quizID";
                            $queryResult = mysqli_query($conn, $totalScorequery);
                            $rowCount = mysqli_num_rows($queryResult);
                            if ($rowCount > 0) {
                                $record = mysqli_fetch_assoc($queryResult);
                                while ($record) {
                                    $studtotalScore = $record['stud_totalpoints'];
                                    break;
                                }
                            }

                            ?>
                            <td style="font-size: 20px;font-weight: bolder;text-align: center;"><?php echo $studtotalScore; ?></td>
                        </tr>
                        <tr>
                            <th>Total Mistakes: </th>
                            <?php
                            $totalmis_query = "SELECT COUNT(mistake)AS totalmistakes FROM `retake_mistake` 
                                    WHERE `user_id`=$userID AND quiz_id=$quizID AND retake_attempt=$attempt";
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
                            $totalhint_query = "SELECT SUM(hint_used)AS totalhintused FROM retake_correct
                                    WHERE `user_id`=$userID AND quiz_id=$quizID AND retake_attempt=$attempt";
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
                            $duration_query = "SELECT * FROM `retake_result` 
                                    WHERE `user_id` = $userID and quiz_id = $quizID and retake_attempt = $attempt";
                            $queryResult = mysqli_query($conn, $duration_query);
                            $rowCount = mysqli_num_rows($queryResult);
                            if ($rowCount > 0) {
                                $record = mysqli_fetch_assoc($queryResult);
                                while ($record) {
                                    if($record['duration'] == ""){
                                        $timeduration = 0;
                                    }else{
                                        $timeduration = $record['duration'];
                                    }
                                    break;
                                    
                                }
                            }
                            ?>
                            <td style="text-align: center;">
                                <?php 
                                if(isset($timeduration)){
                                    if($timeduration <= 0){
                                        echo "less than 1 min";
                                    }else{
                                        echo $timeduration . " min";
                                    }
                                }else{
                                    echo "0";
                                }
                                 ?></td>
                        </tr>
                        <tr>
                            <th>Total Retake Questions: </th>
                            <?php
                            $totalquery = mysqli_query($conn, "SELECT * FROM `quiz_retake` WHERE `user_id`=$userID AND quiz_id=$quizID");
                            $rowcount = mysqli_num_rows($totalquery);
                            if ($rowcount > 0) {
                                while ($row = mysqli_fetch_assoc($totalquery)) {
                                    $quiztotalitem = $row['num_items'];
                                }
                            }

                            ?>
                            <td style="text-align: center;">
                                <?php
                                echo $quiztotalitem; ?></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>



<!-- INPUT RESULT RECORD TO DATABASE -->
<?php
if (isset($_GET['saveResult'])) {
    // INPUT RESULT RECORD TO DATABASE

    $insertResultquery = "INSERT INTO `retake_result`(`user_id`, `quiz_id`, `total_wrong`, `total_hint`, `total_correct`,`total_questions`, `retake_attempt`) 
    VALUES ($userID,$quizID,$studtotalmistake,$studtotalhint,$studtotalScore,$quiztotalitem,$attempt)";
    $insertResult = mysqli_query($conn, $insertResultquery);

    // Identify the attempt that failed........
    // $retakeQuery = mysqli_query($conn, "SELECT COUNT(quiz_attempt) AS num_items FROM `item_retake` 
    //     WHERE quiz_attempt = $attempt");
    // $rowcount = mysqli_num_rows($retakeQuery);
    // if ($rowcount > 0) {
    //     while ($row = mysqli_fetch_assoc($retakeQuery)) {
    //         $numberofItems = $row['num_items'];
    //         if ($numberofItems >= 5) {
    //             $passretake = "INSERT INTO `quiz_retake`(`quiz_id`, `user_id`, `quiz_attempt`, `num_items`) 
    //                 VALUES ($quizID,$userID,$attempt,$numberofItems)";
    //             $insertResult = mysqli_query($conn, $passretake);
    //         }
    //     }
    // }
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
            window.location = "index.php?page=remedial_result";
        });
    </script>
<?php
}
?>
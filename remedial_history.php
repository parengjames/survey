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
$attempt = $_SESSION['attempttake'];

// $viewquery = "SELECT * FROM retake_result WHERE `user_id`=$userID AND quiz_id=$quizID";
// $queryResult = mysqli_query($conn, $viewquery);
// $rowCount1 = mysqli_num_rows($queryResult);
// if ($rowCount1 > 0) {
//     $record1 = mysqli_fetch_assoc($queryResult);
//     while ($record1) {
//         $attempt = $record1['retake_attempt'];


?>

        <body>
            <div class="container-fluid admin">
                <div class="col-md-12 alert alert-primary">Your Remedial Quiz Result</div>
                <br>
                <div class="card">
                    <div class="card-body">
                        <?php
                        $resultquery = mysqli_query($conn, "SELECT * from retake_result where retake_attempt = $attempt and user_id = $userID and quiz_id = $quizID");
                        $rowcount = mysqli_num_rows($resultquery);
                        if ($rowcount > 0) {
                            while ($row = mysqli_fetch_assoc($resultquery)) {
                                $totalcorrect = $row['total_correct'];
                                $totalwrong = $row['total_wrong'];
                                $hintUsedd = $row['total_hint'];
                                $timeduration = $row['duration'];
                                $totalItems = $row['total_questions'];
                        ?>
                                <table class="table table-bordered" id='table' style="width: 600px;margin: auto;">
                                    <tbody>
                                        <tr>
                                            <th style="font-size: 20px;font-weight: bolder;">Your Total Correct: </th>
                                            <td style="font-size: 20px;font-weight: bolder;text-align: center;"><?php echo $totalcorrect; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Total Mistakes: </th>
                                            <td style="text-align: center;color: #FF0000;"><?php echo $totalwrong; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Number of Hint used: </th>
                                            <td style="text-align: center;"><?php echo $hintUsedd; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Time duration: </th>

                                            <td style="text-align: center;">
                                                <?php
                                                if ($timeduration <= 0) {
                                                    echo "less than 1 min";
                                                } else {
                                                    echo $timeduration . " min";
                                                }
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <th>Total Retake Questions: </th>
                                            <td style="text-align: center;">
                                                <?php
                                                echo $totalItems ?></td>
                                        </tr>

                                    </tbody>
                                </table>
                <?php
                            //     }
                            // }
                        break;
                    }
                }
                ?>
                    </div>
                </div>
            </div>
        </body>

</html>
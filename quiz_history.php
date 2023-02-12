<!DOCTYPE html>
<html lang="en">

<head>
</head>

<?php include('header.php') ?>

<?php include('db_connect.php');

?>

<title>Take Quiz</title>
</head>

<body>
    <div class="container-fluid admin">
        <div class="col-md-12 alert alert-primary">Your Quiz Result</div>
        <br>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id='table'>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Quiz Attempt</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        $ATTEMPT;
                        $student_id = $_SESSION['login_id'];
                        $Quiz_Id = $_SESSION['QUIZID'];
                        $_SESSION['quiz-id'] = $Quiz_Id;

                        $sqlgetquery = "SELECT MAX(status)AS getAttempt FROM quiz_attempt
	                        WHERE student_id=$student_id";
                        $queryResult = mysqli_query($conn, $sqlgetquery);
                        $rowCount = mysqli_num_rows($queryResult);
                        if ($rowCount > 0) {
                            $record = mysqli_fetch_assoc($queryResult);
                            while ($record) {
                                $ATTEMPT = $record['getAttempt'];
                                $record = mysqli_fetch_assoc($queryResult);
                            }
                        }

                        $viewquery = "SELECT * FROM quiz_result WHERE `user_id`=$student_id AND quiz_id=$Quiz_Id";
                        $queryResult = mysqli_query($conn, $viewquery);
                        $rowCount1 = mysqli_num_rows($queryResult);
                        if ($rowCount1 > 0) {
                            $record1 = mysqli_fetch_assoc($queryResult);
                            while ($record1) {
                                $count++;
                                $attempts = $record1['quiz_attempt'];
                                $date = $record1['date_saved'];
                                $ispassed;
                                if ($record1['is_passed']) {
                                    $ispassed = "Passed";
                                } else {
                                    $ispassed = "Failed";
                                }
                        ?>

                                <tr>
                                    <td><?php echo $count;   ?></td>
                                    <td><?php echo $attempts; ?></td>
                                    <td><?php echo date('F d Y, h:i:s A', strtotime($date)); ?></td>

                                    <?php
                                    if ($ispassed == "Passed") {
                                    ?>
                                        <td style="color: #32CD32;font-weight: bolder;"><i class="fas fa-check"></i> <?php echo $ispassed; ?></td>
                                    <?php
                                    } else {
                                    ?> <td style="color: #8B0000;"><i class="fas fa-exclamation"></i>
                                            <?php echo $ispassed; ?></td>
                                    <?php
                                    }

                                    echo "<td style='width: 250px;'>";
                                    echo  '<a style="padding: 3px;" type="button" class="btn btn-primary" data-attempt="' . $attempts . '" data-mistake="' . $record1['total_wrong'] . '" data-duration="' . $record1['time_duration'] . '" data-hint="' . $record1['total_hint'] . '" data-score="' . $record1['final_score'] . '" data-toggle="modal" data-target="#resultmodal" style="padding: 8px;color: white;">
                                                        <span class="icon-copy ti-eye"></span> View Details
                                            </a>';
                                    if ($ispassed == "Failed") {
                                        echo '<a data-toggle="modal" data-target="#verifymodal" href="" style="padding: 3px;color: white;margin-left: 4px;" class="btn btn-success">Remedial Quiz</a>';
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                                    ?>
                                </tr>

                        <?php

                                $record1 = mysqli_fetch_assoc($queryResult);
                            }
                        } else {
                            echo "No quiz results found";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>

<!-- MODULE READ MODAL -->
<div class="modal fade" id="resultmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Detailed Result
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body" style="overflow: auto;height: 390px;">
                <table class="table">
                    <tbody>
                        <tr>
                            <th style="font-weight: bold;font-size: 15px;">Total Score: </th>
                            <td><span id="scoreholder"></span></td>
                        </tr>
                        <tr>
                            <th style="font-weight: bold;font-size: 15px;">Quiz Total Score: </th>
                            <?php
                            $totalquestion = $_SESSION['totalpoints'];
                            ?>
                            <td><?php echo $totalquestion; ?></td>
                        </tr>
                        <tr>
                            <th style="font-weight: bold;font-size: 15px;">Total mistakes: </th>
                            <td><span id="mistakesholder"></span></td>
                        </tr>
                        <tr>
                            <th style="font-weight: bold;font-size: 15px;">Total Hint used: </th>
                            <td><span id="hintholder"></span></td>
                        </tr>
                        <tr>
                            <th style="font-weight: bold;font-size: 15px;">Time duration: </th>
                            <td><span id="durationholder"></span><span> mins</span></td>
                        </tr>
                        <tr>
                            <th style="font-weight: bold;font-size: 15px;">Passing Score: </th>
                            <?php $passingscore = $_SESSION['passingscore']; ?>
                            <td><?php echo $passingscore; ?></td>
                        </tr>
                        <tr>
                            <th style="font-weight: bold;font-size: 15px;">Total Items: </th>
                            <?php $etotalpoints = $_SESSION['totalquestion']; ?>
                            <td><?php echo $etotalpoints; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- INITIALIZING THE QUIZ ATTEMPT.... -->
<?php
$stud_quiz_attempt;
if (isset($_SESSION['stud-totalAttempt'])) {
    $stud_quiz_attempt = $_SESSION['stud-totalAttempt'];
} else {
    $student_id = $_SESSION['login_id'];
    $sqlgetquery = "SELECT MAX(status)AS getAttempt FROM retake_attempt
	WHERE student_id=$student_id AND quiz_id=$Quiz_Id";
    $queryResult = mysqli_query($conn, $sqlgetquery);
    $rowCount = mysqli_num_rows($queryResult);
    if ($rowCount > 0) {
        $record = mysqli_fetch_assoc($queryResult);
        while ($record) {
            if ($record['getAttempt'] == 0) {
                $stud_quiz_attempt = 1;
            }
            $record = mysqli_fetch_assoc($queryResult);
        }
    }
}

$getAttempt = $stud_quiz_attempt - 1;
$_SESSION['attempttake'] = $getAttempt;

?>

<!-- VERIFY TO TAKE EXAMS....-->
<div style="margin-top: 150px;" class="modal fade" id="verifymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel" style="font-weight: bolder;">Are you ready?</h3>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <h4>Proceed to the Remedial Quiz Now</h4><br>
                <span style="font-weight: bold;">Note: You need to give the correct answer. 1 points in each question, 1 or more mistake means wrong.</span>
            </div>
            <div class="modal-footer">
                <?php
                $query = mysqli_query($conn, "SELECT * FROM retake_result WHERE user_id = $student_id and retake_attempt = $getAttempt");
                $rowcount = mysqli_num_rows($query);
                if ($rowcount > 0) {
                    ?>
                    <a class="btn btn-primary" href="index.php?page=remedial_history">Show Results</a>
                    <?php
                }
                ?>

                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-success" href="remedial_quiz.php?attempt=<?php echo $stud_quiz_attempt; ?>">Start now</a>
            </div>
        </div>
    </div>
</div>

<script>
    $('#resultmodal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var attmpt = button.data('attempt')
        var mstake = button.data('mistake')
        var hnt = button.data('hint')
        var drt = button.data('duration')
        var scre = button.data('score')

        var modal = $(this)
        modal.find('#attemptholder').html(attmpt)
        modal.find('#mistakesholder').html(mstake)
        modal.find('#hintholder').html(hnt)
        modal.find('#scoreholder').html(scre)
        modal.find('#durationholder').html(drt)
    });
</script>
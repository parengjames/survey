<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    session_start();
    ob_start();
    $title = isset($_GET['page']) ? ucwords(str_replace("_", ' ', $_GET['page'])) : "Home";
    ?>
    <title><?php echo $title ?> | SETI</title>
    <?php ob_end_flush() ?>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="assets/dist/css/styles.css">
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- summernote -->
    <link rel="stylesheet" href="assets/plugins/summernote/summernote-bs4.min.css">
</head>
<style>
    .swal-text {
        text-align: center;
    }
</style>

<?php include('db_connect.php');

// GETTING THE NEXT Q ITEM .................
$item_num;
if (isset($_GET['question'])) {
    $item_num = $_GET['question'];
} else {
    $item_num = 1;
}
$_SESSION['itemNum'] = $item_num;

// getting how many mistakes.........
$mistakes;
if (isset($_GET['repeat'])) {
    $mistakes = $_GET['repeat'];
} else {
    $mistakes = 0;
}
$_SESSION['over'] = $mistakes;

$hintValue;
if (isset($_GET['usehint'])) {
    $hintValue = $_GET['usehint'];
} else {
    $hintValue = 0;
}

?>

<?php
// using the value of attempts..........
$quizAttempt;
if (isset($_GET['attempt'])) {
    $quizAttempt = $_GET['attempt'];
    $_SESSION['quiz_attempt'] = $quizAttempt;
    $userID = $_SESSION['login_id'];
    $quizID = $_SESSION['quiz-id'];

    $attemptQuery = "INSERT INTO `quiz_attempt`(`student_id`, `quiz_id`, `status`)
      VALUES ($userID,$quizID,$quizAttempt)";
    $result = mysqli_query($conn, $attemptQuery);
}
if (isset($quizAttempt)) {
    $_SESSION['stud_totalAttempt'] = ++$quizAttempt;
}
?>
<style>
    .score {
        text-align: right;
        margin-right: 2in;
    }
</style>
</head>
<br>
<!-- getting total score -->
<?php
$user = $_SESSION['login_id'];
$quiz = $_SESSION['quiz-id'];
$attemptss;

$getattempt = "SELECT MAX(status) AS updatestats FROM quiz_attempt WHERE student_id=$user";
$queryResult = mysqli_query($conn, $getattempt);
$rowCount = mysqli_num_rows($queryResult);
if ($rowCount > 0) {
    $record = mysqli_fetch_assoc($queryResult);
    while ($record) {
        $status = $record['updatestats'];
        $attemptss = $status;
        break;
    }
}

$totalscorequery = "SELECT SUM(points) AS totalpoints FROM quiz_correct
    WHERE user_id=$user AND quiz_id=$quiz AND quiz_attempt=$attemptss";
$queryResult = mysqli_query($conn, $totalscorequery);
$rowCount = mysqli_num_rows($queryResult);

$totalScore;

if ($rowCount > 0) {
    $record = mysqli_fetch_assoc($queryResult);
    while ($record) {
        $total = $record['totalpoints'];
        $totalScore = $total;
        break;
    }
}
if ($totalScore == "") {
    $totalScore = 0;
}
?>

<body>
    <div class="score">
        <h3 style="font-weight: bolder;color: DodgerBlue;">Your Score:
            <span style="font-weight: bolder;color: #4169E1;font-size: 40px;"><?php echo $totalScore; ?></span>
        </h3>
    </div>
    <div style="width: 12in;" class="container-fluid admin">

        <div class="alert alert-primary">
            <h3 style="font-weight: bolder;">Lesson 1 Quiz</h3>
            <span>Take your time to answer every question. Goodluck to you.</span>
        </div>

        <?php
        //........................................
        $query = "SELECT * FROM quiz_item WHERE quizItemID = $item_num";
        $queryResult = mysqli_query($conn, $query);
        $rowCount = mysqli_num_rows($queryResult);

        $totalquest = $_SESSION['totalquestion'];

        if ($rowCount > 0) {
            $record = mysqli_fetch_assoc($queryResult);
            while ($record) {
                $item = $record['question'];
                $itemid = $record['quizItemID'];
                $itemAnswerkey = $record['answerkey'];
                $storedhint = $record['hint'];

                $_SESSION['availableHint'] = $storedhint;
        ?>
                <div class="card">
                    <div class="card-header">
                        <h4 style="font-weight: bolder;color: DodgerBlue;">Question <?php echo $item_num ?> of <?php echo $totalquest; ?></h4>
                    </div>
                    <div class="card-body ">
                        <table class="table" id='table'>
                            <thead>
                                <tr>
                                    <!-- question here....... -->
                                    <th style="vertical-align: middle;width: 300px;font-size: 20px;" colspan="3" class="table-plus datatable-nosort user-select-none">
                                        <?php echo $item; ?>
                                    </th>
                                    <th style="vertical-align: middle;width: 80px;text-align: center;">
                                        <?php
                                        if ($mistakes >= 3) {
                                        ?>
                                            <a class="btn btn-sm btn-success" data-toggle="modal" data-target="#hintConfirm" style="width: 70px; font-size: 16px;">
                                                <i class="fas fa-lightbulb"></i> Hint
                                            </a>
                                        <?php
                                        }
                                        ?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <form action="quiz_backend.php" method="POST">
                                        <input type="text" id="questionID" name="question_id" value="<?php echo $itemid; ?>" hidden>
                                        <input type="text" id="anskey" name="answerkey" value="<?php echo $itemAnswerkey; ?>" hidden>
                                        <input type="text" id="hintattempt" name="hintusage" value="<?php echo $hintValue; ?>" hidden>
                                        <td style="width: 150px;">
                                            <button style="border: none;background-color: white;cursor: default;" type="submit" name="submit">
                                                <input style="cursor: pointer;" type="radio" id="ch1" name="answer" value="<?php
                                                                                                                            if ($mistakes == 1) {
                                                                                                                                echo $record['ch3'];
                                                                                                                            } else if ($mistakes == 2) {
                                                                                                                                echo $record['ch2'];
                                                                                                                            } else if ($mistakes == 3) {
                                                                                                                                echo $record['ch1'];
                                                                                                                            } else {
                                                                                                                                echo $record['ch1'];
                                                                                                                            } ?>" hidden>
                                                <label style="vertical-align: middle;font-size: 18px;cursor: pointer;" for="ch1">
                                                    a.
                                                    <?php
                                                    if ($mistakes == 1) {
                                                        echo $record['ch3'];
                                                    } else if ($mistakes == 2) {
                                                        echo $record['ch2'];
                                                    } else if ($mistakes == 3) {
                                                        echo $record['ch1'];
                                                    } else {
                                                        echo $record['ch1'];
                                                    } ?>
                                                </label>
                                            </button>
                                        </td>
                                        <td style="width: 150px;">
                                            <button style="border: none; background-color: white;cursor: default;" type="submit" name="submit">
                                                <input style="cursor: pointer;" type="radio" id="ch2" name="answer" value="<?php
                                                                                                                            if ($mistakes == 1) {
                                                                                                                                echo $record['ch1'];
                                                                                                                            } else if ($mistakes == 2) {
                                                                                                                                echo $record['ch3'];
                                                                                                                            } else if ($mistakes == 3) {
                                                                                                                                echo $record['ch2'];
                                                                                                                            } else {
                                                                                                                                echo $record['ch2'];
                                                                                                                            }
                                                                                                                            ?>" hidden>
                                                <label style="vertical-align: middle;font-size: 18px;cursor: pointer;" for="ch2">
                                                    b.
                                                    <?php
                                                    if ($mistakes == 1) {
                                                        echo $record['ch1'];
                                                    } else if ($mistakes == 2) {
                                                        echo $record['ch3'];
                                                    } else if ($mistakes == 3) {
                                                        echo $record['ch2'];
                                                    } else {
                                                        echo $record['ch2'];
                                                    }
                                                    ?>
                                                </label>
                                            </button>
                                        </td>
                                        <td style="width: 150px;">
                                            <button style="border: none; background-color: white;cursor: default;" type="submit" name="submit">
                                                <input style="cursor: pointer;" type="radio" id="ch3" name="answer" value="<?php
                                                                                                                            if ($mistakes == 1) {
                                                                                                                                echo $record['ch2'];
                                                                                                                            } else if ($mistakes == 2) {
                                                                                                                                echo $record['ch1'];
                                                                                                                            } else if ($mistakes == 3) {
                                                                                                                                echo $record['ch3'];
                                                                                                                            } else {
                                                                                                                                echo $record['ch3'];
                                                                                                                            }
                                                                                                                            ?>" hidden>
                                                <label style="vertical-align: middle; font-size: 18px;cursor: pointer;" for="ch3">
                                                    c.
                                                    <?php
                                                    if ($mistakes == 1) {
                                                        echo $record['ch2'];
                                                    } else if ($mistakes == 2) {
                                                        echo $record['ch1'];
                                                    } else if ($mistakes == 3) {
                                                        echo $record['ch3'];
                                                    } else {
                                                        echo $record['ch3'];
                                                    }
                                                    ?>
                                                </label>
                                            </button>
                                        </td>
                                        <td style="width: 150px;">
                                            <button style="border: none; background-color: white;cursor: default;" type="submit" name="submit">
                                                <input style="cursor: pointer;" type="radio" id="ch4" name="answer" value="<?php echo $record['ch4']; ?>" hidden>
                                                <label style="vertical-align: middle;font-size: 18px;cursor: pointer;" for="ch4">
                                                    d. <?php echo $record['ch4']; ?>
                                                </label>
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
    </div>
<?php
                break;
            }
        }
?>
</body>

<!-- Notification HINT modal confirmation -->
<div class="modal fade" id="hintConfirm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center font-18">
                <h4 class="padding-top-30 mb-30 weight-500">
                    Use your hint now?
                </h4>
                <div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto">
                    <div class="col-6">
                        <button style="color: red;" type="button" class="btn btn-light border-radius-100 btn-block confirmation-btn" data-dismiss="modal">
                            <i class="fa fa-times"></i>
                        </button>
                        NO
                    </div>
                    <div class="col-6">
                        <button onclick="availablehint()" style="color: #00FA9A;" type="button" class="btn btn-light border-radius-100 btn-block confirmation-btn" data-dismiss="modal">
                            <i class="fa fa-check"></i>
                        </button>
                        YES
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require "footer.php"; ?>




<!-- SCRIPT FOR SWEETALERT -->
<script src="assets/plugins/sweetalert2/sweetalert.min.js"></script>
<script src="assets/plugins/sweetalert2/jquery-3.6.1.min.js"></script>
<!-- for sweet alert........... -->

<!-- NOTIFICATION OF WRONG ANSWER -->
<?php
if (isset($_SESSION['headertext'])) {
    if (isset($_SESSION['bodytext'])) {
        if (isset($_SESSION['statusIcon'])) {
?>
            <script>
                swal({
                    title: "<?php echo $_SESSION['headertext'] ?>",
                    text: "<?php echo $_SESSION['bodytext'] ?>",
                    icon: "<?php echo $_SESSION['statusIcon'] ?>",
                });
            </script>
<?php
        }
    }
}
unset($_SESSION['headertext']);
?>

<!-- hint details -->
<script>
    function availablehint() {
        swal({
            title: '"<?php echo $_SESSION['availableHint']; ?>"',
            icon: 'info',
            button: 'Close',
        }).then(function() {
            <?php
            $clicked = 1;
            ?>
            window.location =
                "quiz_lesson1.php?repeat=<?php echo $mistakes; ?>&question=<?php echo $item_num; ?>&usehint=<?php echo $clicked; ?>";
        });
    }
</script>

<!-- NOTIFICATION OF CORRECT ANSWER -->
<?php
if (isset($_SESSION['headertextitem'])) {
    if (isset($_SESSION['bodytextitem'])) {
        if (isset($_SESSION['ItemStatus'])) {
?>
            <script>
                swal({
                    title: "<?php echo $_SESSION['headertextitem'] ?>",
                    text: "<?php echo $_SESSION['bodytextitem'] ?>",
                    icon: "<?php echo $_SESSION['ItemStatus'] ?>",
                    button: 'next'
                }).then(function() {
                    window.location = "quiz_lesson1.php?question=<?php echo $_SESSION['nextitem']; ?>";
                });
            </script>
<?php
        }
    }
}
unset($_SESSION['headertextitem']);
?>

<!-- DISPLAY IF SUBMIT ANSWER IS EMPTY -->
<?php
if (isset($_SESSION['headertext_empty'])) {
    if (isset($_SESSION['bodytext_empty'])) {
        if (isset($_SESSION['statusIcon_empty'])) {

?>
            <script>
                swal({
                    title: "<?php echo $_SESSION['headertext_empty']; ?>",
                    text: "<?php echo $_SESSION['bodytext_empty']; ?>",
                    icon: '<?php echo $_SESSION['statusIcon_empty']; ?>',
                });
            </script>
<?php

        }
    }
}
unset($_SESSION['headertext_empty']);
?>

<!-- SWEET ALERT FOR LAST QUESTION -->
<?php
if (isset($_SESSION['headertextlast'])) {
    if (isset($_SESSION['bodytextlast'])) {
        if (isset($_SESSION['statusIconlast'])) {
?>

            <script>
                swal({
                    title: "<?php echo $_SESSION['headertextlast'] ?>",
                    text: "<?php echo $_SESSION['bodytextlast'] ?>",
                    icon: '<?php echo $_SESSION['statusIconlast'] ?>',
                    button: 'See Result'
                }).then(function() {
                    window.location = "index.php?page=excircle_result&saveResult=1";
                });
            </script>
<?php
        }
    }
}
unset($_SESSION['headertextlast']);
?>

</html>
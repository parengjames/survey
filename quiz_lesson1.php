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
 <!-- summernote -->
  <link rel="stylesheet" href="assets/plugins/summernote/summernote-bs4.min.css">
</head>
<?php include('db_connect.php');

// GETTING THE NEXT Q ITEM .................
$item_num;
if (isset($_GET['question'])) {
    $item_num = $_GET['question'];
} else {
    $item_num = 1;
}
$_SESSION['itemNum'] = $item_num;

?>
<style>
    .score {
        text-align: right;
        margin-right: 2in;
    }
</style>
</head>
<br>

<body>
    <div class="score">
        <h3 style="font-weight: bolder;color: DodgerBlue;">Score:
            <span style="font-weight: bolder;color: #4169E1;font-size: 40px;">75</span>
        </h3>
    </div>
    <div style="width: 12in;" class="container-fluid admin">

        <div class="alert alert-primary">
            <h3 style="font-weight: bolder;">Lesson 1 Quiz</h3>
            <span>Take your time to answer every question. Goodluck to you.</span>
        </div>

        <?php
        //........................................
        $query = "SELECT * FROM quiz_item WHERE quizItemID = 1";
        $queryResult = mysqli_query($conn, $query);
        $rowCount = mysqli_num_rows($queryResult);

        if ($rowCount > 0) {
            $record = mysqli_fetch_assoc($queryResult);
            while ($record) {
                $item = $record['question'];
                $itemid = $record['quizItemID'];
                $itemAnswerkey = $record['answerkey'];
                $storedhint = $record['hint'];


        ?>

                <div class="card">
                    <div class="card-header">
                        <h4 style="font-weight: bolder;color: DodgerBlue;">Question 1 of 15</h4>
                    </div>
                    <div class="card-body ">
                        <table class="table" id='table'>
                            <thead>
                                <tr>
                                    <!-- question here....... -->
                                    <th style="vertical-align: middle;width: 300px;font-size: 20px;" colspan="3" class="table-plus datatable-nosort user-select-none">
                                        <?php echo $item; ?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <form action="quiz_backend.php" method="POST">
                                        <input type="text" id="questionID" name="question_id" value="<?php echo $itemid; ?>" hidden>
                                        <input type="text" id="anskey" name="answerkey" value="<?php echo $itemAnswerkey; ?>" hidden>
                                        <input type="text" id="hintattempt" name="hintusage" value="<?php echo $storedhint; ?>" hidden>
                                        <td style="width: 150px;">
                                            <button style="border: none;background-color: white;cursor: default;" type="submit" name="submit">
                                                <input style="cursor: pointer;" type="radio" id="ch1" name="answer" value="<?php
                                                                                                                            // if ($mistakes == 1) {
                                                                                                                            //     echo $record['ch3'];
                                                                                                                            // } else if ($mistakes == 2) {
                                                                                                                            //     echo $record['ch2'];
                                                                                                                            // } else if ($mistakes == 3) {
                                                                                                                            //     echo $record['ch1'];
                                                                                                                            // } else {
                                                                                                                            echo $record['ch1'];
                                                                                                                            ?>" hidden>
                                                <label style="vertical-align: middle;font-size: 18px;cursor: pointer;" for="ch1">
                                                    a.
                                                    <?php
                                                    // if ($mistakes == 1) {
                                                    //     echo $record['ch3'];
                                                    // } else if ($mistakes == 2) {
                                                    //     echo $record['ch2'];
                                                    // } else if ($mistakes == 3) {
                                                    //     echo $record['ch1'];
                                                    // } else {
                                                    echo $record['ch1'];
                                                    ?>
                                                </label>
                                            </button>
                                        </td>
                                        <td style="width: 150px;">
                                            <button style="border: none; background-color: white;cursor: default;" type="submit" name="submit">
                                                <input style="cursor: pointer;" type="radio" id="ch2" name="answer" value="<?php
                                                                                                                            // if ($mistakes == 1) {
                                                                                                                            //     echo $record['exam_ch1'];
                                                                                                                            // } else if ($mistakes == 2) {
                                                                                                                            //     echo $record['exam_ch3'];
                                                                                                                            // } else if ($mistakes == 3) {
                                                                                                                            //     echo $record['exam_ch2'];
                                                                                                                            // } else {
                                                                                                                            echo $record['ch2'];
                                                                                                                            // } 
                                                                                                                            ?>" hidden>
                                                <label style="vertical-align: middle;font-size: 18px;cursor: pointer;" for="ch2">
                                                    b.
                                                    <?php
                                                    // if ($mistakes == 1) {
                                                    //     echo $record['exam_ch1'];
                                                    // } else if ($mistakes == 2) {
                                                    //     echo $record['exam_ch3'];
                                                    // } else if ($mistakes == 3) {
                                                    //     echo $record['exam_ch2'];
                                                    // } else {
                                                    echo $record['ch2'];
                                                    //} 
                                                    ?>
                                                </label>
                                            </button>
                                        </td>
                                        <td style="width: 150px;">
                                            <button style="border: none; background-color: white;cursor: default;" type="submit" name="submit">
                                                <input style="cursor: pointer;" type="radio" id="ch3" name="answer" value="<?php
                                                                                                                            // if ($mistakes == 1) {
                                                                                                                            //     echo $record['exam_ch2'];
                                                                                                                            // } else if ($mistakes == 2) {
                                                                                                                            //     echo $record['exam_ch1'];
                                                                                                                            // } else if ($mistakes == 3) {
                                                                                                                            //     echo $record['exam_ch3'];
                                                                                                                            // } else {
                                                                                                                            echo $record['ch3'];
                                                                                                                            // } 
                                                                                                                            ?>" hidden>
                                                <label style="vertical-align: middle; font-size: 18px;cursor: pointer;" for="ch3">
                                                    c.
                                                    <?php
                                                    // if ($mistakes == 1) {
                                                    //     echo $record['exam_ch2'];
                                                    // } else if ($mistakes == 2) {
                                                    //     echo $record['exam_ch1'];
                                                    // } else if ($mistakes == 3) {
                                                    //     echo $record['exam_ch3'];
                                                    // } else {
                                                    echo $record['ch3'];
                                                    //} 
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

<?php require "footer.php"; ?>


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

<!-- SCRIPT FOR SWEETALERT -->
<script src="assets/plugins/sweetalert2/sweetalert.min.js"></script>
<script src="assets/plugins/sweetalert2/jquery-3.6.1.min.js"></script>
<!-- for sweet alert........... -->

<?php
    if(isset($_SESSION['headertext'])){
        if(isset($_SESSION['bodytext'])){
            if(isset($_SESSION['statusIcon'])){
                ?>
                <script>
                    swal({
                        title:"<?php echo $_SESSION['headertext'] ?>",
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
<script>
function clicknow() {
    swal({
        title: "Oopsss! 🫣",
        text: "Looks like you haven't Read the Lessons yet",
        icon: 'warning',
    });
}
</script>

</html>

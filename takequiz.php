<!DOCTYPE html>
<html lang="en">

<head>
</head>

<?php include('header.php')?>

<?php include('db_connect.php');

?>

<title>Take Quiz</title>
</head>

<body>
	<div class="container-fluid admin">
		<div class="col-md-12 alert alert-primary">Current Available Quiz</div>
		<br>
		<div class="card">
			<div class="card-body">
				<table class="table table-bordered" id='table'>

					<thead>
						<tr>
							<th>ID</th>
							<th>Quiz Title</th>
							<th>Quiz Description</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$query = "SELECT * FROM `quiz`";

						$result = mysqli_query($conn, $query);

						if (mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_assoc($result)) {
								$quizid = $row["quiz_id"];
								
								//SESSION START.......
								$_SESSION['quiz-id'] = $quizid;
								echo "<tr>";

								echo "<td>" . $row["quiz_id"] . "</td>";

								echo "<td>" . $row["Quiz_title"] . "</td>";

								echo "<td>" . $row["Quiz_desc"] . "</td>";

								?>
								<td>
								<a data-toggle="modal" data-target="#verifymodal" href="" class=" btn btn-md btn-primary">
                                    <span class="icon-copy ti-check"></span> Start Quiz
                                </a>
								</td>
								<?php

								// echo '<td><a href="quiz_lesson1.php?quiznum=' . $row['quiz_id'] . '" type="button" class="btn btn-primary btn-sm>"</a> Start Quiz</td>';
							}
						}
						?>
</body>
<!-- INITIALIZING THE QUIZ ATTEMPT.... -->
<?php
$stud_quiz_attempt;
if(isset($_SESSION['stud_totalAttempt'])){
	$stud_quiz_attempt = $_SESSION['stud_totalAttempt'];
}else{
	$student_id = $_SESSION['login_id'];
	$sqlgetquery = "SELECT MAX(status)AS getAttempt FROM quiz_attempt
	WHERE student_id=$student_id AND quiz_id=$quizid";
	$queryResult = mysqli_query($conn, $sqlgetquery);
    $rowCount = mysqli_num_rows($queryResult);
	if ($rowCount > 0) {
        $record = mysqli_fetch_assoc($queryResult);
        while ($record) {
            if ($record['getAttempt'] == 0) {
                $stud_quiz_attempt = 1;
            } else {
                $stud_quiz_attempt = ++$record['getAttempt'];
            }
            $record = mysqli_fetch_assoc($queryResult);
        }
    }
}
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
            <div class="modal-body"><h4>Proceed to the Quiz Now</h4>
				<span>Note: When started, there is no turning back.</span>
			</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-success" href="quiz_lesson1.php?attempt=<?php echo $stud_quiz_attempt; ?>">Start now</a>
            </div>
        </div>
    </div>
</div>

</html>
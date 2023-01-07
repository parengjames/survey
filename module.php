<!DOCTYPE html>
<html lang="en">
<head>
	</head>

    	<?php include('header.php') ?>

	<?php include('db_connect.php');
?>
	<title>ANATOMY OF THE HEART</title>
    <link rel="stylesheet" href="styles/style.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
<!--	<?php include('nav_bar.php') ?>-->


<!--<div class="card" style="width: 18rem;">
<br> <br>
  <div class="card-body"  style="margin-left: 20px;">
    <h5 class="card-title" style='font-size:25px;' ><b>Module 1 Lessons</b></h5>
	<br><br>
    <a href="lesson1.php"  style='font-size:22px;'>Lesson 1</a><br>
    <a href="lesson2.php" style='font-size:22px;' >Lesson 2</a><br>
	<a href="lesson3.php" style='font-size:22px;' >Lesson 3</a><br>
    <a href="lesson4.php" style='font-size:22px;' >Lesson 4</a><br>
	<a href="lesson5.php" style='font-size:22px;' >Lesson 5</a><br>


  </div>
</div> -->

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Lesson_Title</th>
      <th scope="col">Lesson_Description</th>
      <th scope="col">View Lesson</th>
    </tr>
  </thead>
  <tbody>

    <tr>
      <th scope="row">1</th>
      <td>Lesson 1</td>
      <td>Anatomy of the heart</td>
      <td><a href=index.php?page=module1 type="button" class="btn btn-primary btn-sm>">View Lesson</a></td>
    </tr>

    <tr>
      <th scope="row">2</th>
      <td>Lesson 2</td>
      <td>Heart Valve</td>
      <td><a href=lesson2.php type="button" class="btn btn-primary btn-sm>">View Lesson</a></td>
    </tr>
    
  
  </tbody>
</table>


</body>
</html>
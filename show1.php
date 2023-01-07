
<?php

include('db_connect.php');

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INDEX 3</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="ckeditor/ckeditor.js"></script>
</head>
<body>

<br>

<a href="index3.php"> <button type="button" class="btn btn-primary">Add Content Module</button></a>
<a  href="index.php"><button type="button" class="btn btn-danger">Back</button></a>
<br><br><br>

<table  class="table table-striped table-bordered"> 




<br><br>


<!--<h1 style="text-align:center;"> TABLE OF CONTENTS</h1>-->

<tr>
    <th>ID</th>
    <th>Quiz Title</th>
    <th>Quiz</th>
</tr>

<?php
$query = "SELECT * FROM `quizlist`";

$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0){

    while($row= mysqli_fetch_assoc($result)){
        echo "<tr>";

        echo "<td>".$row["id"]."</td>";

        echo "<td>".$row["Quiz_title"]."</td>";

        echo "<td>".$row["Quiz_desc"]."</td>";

        echo '<td><a href="update2.php?id='.$row['id'].'" type="button" class="btn btn-primary btn-sm>"</a> EDIT</td>';
        echo '<td><a href="#?id='.$row['id'].'" type="button" class="btn btn-danger btn-sm>"</a>DELETE</td>';
    }
}
?>
</table>
    


</body>
</html>
<?php

include('db_connect.php');

if ($_GET['id']){

    $id = $_GET['id'];
    $query = "SELECT * FROM `quizlist` WHERE id = '$id'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0){
 //we have data
  while ($row = mysqli_fetch_assoc($result)){
            $content = $row['Quiz_desc'];
        }
    }
}else{
    header('Location:index3.php');
}


if (isset($_POST['submit'])) {
    if (isset($_POST['editor']) && !empty($_POST['editor'])){
        $content = $_POST['editor'];
    }else{
        $empty_error = '<b class="text-danger text-center> Please fill  the textarea</b>';
    }
    if (isset($content) && !empty($content)) 
    
    {
        $insert_q = "UPDATE`quizlist` SET Quiz_desc = '$content'
         WHERE id='$id'";

        if (mysqli_query($conn,$insert_q)){

        }else{
            $submit_error = '<b class="text-danger text-center>You are not available to submit.Please try again</b>';
        }
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INDEX 3</title>
    <link rel="stylesheet" href="css/stylee.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="ckeditor/ckeditor.js"></script>
</head>
<body>

<br>

<a href="index3.php"> <button type="button" class="btn btn-primary">Add Quiz</button></a>
<a  href="show1.php"><button type="button" class="btn btn-success">View </button></a>
<a  href="index.php"><button type="button" class="btn btn-danger">Back</button></a>
<br><br><br>

<?php if(isset($submit_error)) echo $submit_error; ?>
<?php if(isset($empty_error)) echo $empty_error; ?>
<div class="input-field">
<form action="" method="post" enctype="multipart/form-data">
        <label for="title"> Enter title</label>
       <input type="text" name="Article_title" id="title" autocomplete="off">
       </div>
    <textarea class="ckeditor" name="editor"><?php if (isset($content))
        echo $content;?> </textarea>

    <br>

    <button type="submit" name="submit" class="btn btn-success">PUBLISH</button>
</form>
    
    <script>
            CKEDITOR.replace('editor');
      </script>
</body>
</html>
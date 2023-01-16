<?php include('db_connect.php');

    if(isset($_POST['submit'])){

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];


    if(!empty($fname)|| !empty($lname) || !empty($gender) || !empty($email) || !empty($pass) || !empty($cpass)){

        $query = "INSERT INTO register (firstname,lastname,gender, email,password1) values ('$fname','$lname','$gender','$email','$pass')";

        $run = mysqli_query($conn, $query) or die('Error: ' . mysqli_error($conn));

        if($run){
            header("Location:../login.php");
        } else {
            echo "error";
        }
    }

    }
?>


<?php
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "phpdatabase";
    session_start();

    $dbCon = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

   /* if($dbCon){
        echo "Databse Connection Successfull";
    }else{
        die("Database Connection Failed");
    }*/
    function displayAlert($message){
        echo "<script>alert('$message');</script>";
    }
?>
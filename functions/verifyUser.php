<?php
if(isset($_POST["submit"])){
    require "dbaseconnect.php";

    $username = $_POST["username"];
    $password = $_POST["password"];
    
    if(empty($username) || empty($password)){
        //echo "Invalid Data";
        header("Location: ..\login.php?error=InvalidData");
    }else{
        //all good
        //check whether the username exists
        $sql = "SELECT * FROM users where username=? and password=?";
        $statement = mysqli_stmt_init($dbCon);
        if(!mysqli_stmt_prepare($statement, $sql)){
            //echo "Database Error";
            header("Location: ..\login.php?error=DatabaseError");
        }else{
            mysqli_stmt_bind_param($statement, "ss", $username, $password);
            mysqli_stmt_execute($statement);
            mysqli_stmt_store_result($statement);
            $recordCount = mysqli_stmt_num_rows($statement);
            if($recordCount>0){
                $_SESSION["LoggedinUser"] = $username;
                header("Location:../index.php");
            }else{
                //echo "ACCESS DENIED";
                header("Location: ..\login.php?error=AccessDenied");
            }
        }
    }

}else{
    //echo "ACCESS DENIED";
    header("Location: ..\login.php?error=AccessDenied");
}


?>
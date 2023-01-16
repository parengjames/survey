<?php
if(isset($_POST["submit"])){
    require "dbaseconnect.php";
    

    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmpassword"];
    
    if(empty($username) || empty($password) || empty($confirmPassword)){
        header("Location:..\\forgot-password.php?error=InvalidData");
        //echo "Invalid Data";
    }else if(!preg_match("/^[a-zA-Z0-9]*/",$username)){
        //echo "Username is invalid";
        header("Location:..\\forgot-password.php?error=UsernameIsInvalid");
    }else if($password != $confirmPassword ){
        //echo "Password Don't Match";
        header("Location:..\\forgot-password.php?error=PasswordNotMatch");
    }else{
        //all good
        //check whether the username exists
        //$sql = "UPDATE `users` SET `password`='$password ' WHERE '$username'";
        $sql = "SELECT * FROM users where username=?";
        $statement = mysqli_stmt_init($dbCon);
        if(!mysqli_stmt_prepare($statement, $sql)){
            //echo "Database Error";
            header("Location:..\\forgot-password.php?error=DatabaseError");
        }else{
            mysqli_stmt_bind_param($statement, "s", $username);
            mysqli_stmt_execute($statement);
            mysqli_stmt_store_result($statement);
            $recordCount = mysqli_stmt_num_rows($statement);
            if($recordCount>0){
                //echo "User Already Exists";
                $sql = "UPDATE `user` SET `password`='$password' WHERE `username`='$username'";
                $statement = mysqli_stmt_init($dbCon);
                if(!mysqli_stmt_prepare($statement, $sql)){
                    //echo "Database Error";
                    header("Location:..\\forgot-password.php?error=DatabaseError");
                }else{
                    if ($dbCon->query($sql) === TRUE) {
                        //echo "Record updated successfully";
                        header("Location:..\\forgot-password.php?error=PasswordUpdated");
                      } else {
                        header("Location:..\\forgot-password.php?error=DatabaseError");
                      }
                      
                      $dbCon->close();
                }




            }else{
                //echo "NotExist";
                header("Location:..\\forgot-password.php?error=NotExist");
            }
        }
    }

}else{
    //echo "ACCESS DENIED";
    header("Location:..\\forgot-password.php?error=AccessDenied");
}


?>
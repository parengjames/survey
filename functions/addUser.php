<?php
if(isset($_POST["submit"])){
    require "dbaseconnect.php";

    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmpassword"];
    $usertype = $_POST["usertype"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    
    if(empty($username) || empty($password) || empty($confirmPassword) || empty($usertype) || empty($firstname) || empty($lastname) ){
        header("Location:..\\register.php?error=InvalidData");
        //echo "Invalid Data";
    }else if(!preg_match("/^[a-zA-Z0-9]*/",$username)){
        //echo "Username is invalid";
        header("Location:..\\register.php?error=UsernameIsInvalid");
    }else if($password != $confirmPassword){
        //echo "Password Don't Match";
        header("Location:..\\register.php?error=PasswordNotMatch");
    }else{
        //all good
        //check whether the username exists
        $sql = "SELECT * FROM users where username=?";
        $statement = mysqli_stmt_init($dbCon);
        if(!mysqli_stmt_prepare($statement, $sql)){
            //echo "Database Error";
            header("Location:..\\register.php?error=DatabaseError");
        }else{
            mysqli_stmt_bind_param($statement, "s", $username);
            mysqli_stmt_execute($statement);
            mysqli_stmt_store_result($statement);
            $recordCount = mysqli_stmt_num_rows($statement);
            if($recordCount>0){
                //echo "User Already Exists";
                header("Location:..\\register.php?error=AlreadyExist");
            }else{
                $sql = "INSERT INTO users (`username`, `password`, `usertype`,`firstname`,`lastname`) VALUES (?,?,?,?,?)";
                $statement = mysqli_stmt_init($dbCon);
                if(!mysqli_stmt_prepare($statement, $sql)){
                    //echo "Databse Error";
                    header("Location:..\\register.php?error=DatabaseError");
                }else{
                    mysqli_stmt_bind_param($statement, "sssss", $username,$password, $usertype,$firstname,$lastname,);
                    mysqli_stmt_execute($statement);
                    //echo "New User Added";
                    header("Location:..\\register.php?error=NewUserAdded");
                }
            }
        }
    }

}else{
    //echo "ACCESS DENIED";
    header("Location:..\\register.php?error=AccessDenied");
}


?>
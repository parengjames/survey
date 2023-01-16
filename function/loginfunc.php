<?php
include('db_connect.php');
if(isset($_POST['log'])){
	$email = $_POST['email'];
	$pass = $_POST['password'];

	if(empty($email) || empty($pass)){
		header("Location:../login.php?error=InvalidData");
	} else {
        //all good
        //check whether the username exists
        $sql = "SELECT * FROM register where email=? and password1=?";
      
        $statement = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($statement, $sql)){
            header("Location:../login.php?error=DatabaseError");
        }else{
            mysqli_stmt_bind_param($statement, "ss", $email, $password);
            mysqli_stmt_execute($statement);
            mysqli_stmt_store_result($statement);
            $recordCount = mysqli_stmt_num_rows($statement);
            if($recordCount>0){
                $_SESSION["LoggedinUser"] = $email;
               
                
                header("Location:../home.php");
            }else{
                
                header("Location:../home.php?error=AccessDenied");
              

            }
        }
    } 

}else{
    
     header("Location:../home.php?error=AccessDenied");


}
?>
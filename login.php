<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login</title>
 	

<?php include('header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>

<!-- <?php
if(isset($_SESSION['login_id'])){
	$email = $_POST['email'];
	$pass = $_POST['password'];

	if(empty($email) || empty($pass)){
		header("login.php?error=InvalidData");
	} else {
        //all good
        //check whether the username exists
        $sql = "SELECT * FROM register where email=? and password1=?";
      
        $statement = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($statement, $sql)){
            header("login.php?error=DatabaseError");
        }else{
            mysqli_stmt_bind_param($statement, "ss", $email, $password);
            mysqli_stmt_execute($statement);
            mysqli_stmt_store_result($statement);
            $recordCount = mysqli_stmt_num_rows($statement);
            if($recordCount>0){
                $_SESSION["LoggedinUser"] = $email;
               
                
                header("location:index.php?page=home");
            }else{
                
                header("login.php?error=AccessDenied");
              

            }
        }
    } 

}else{
    
     header("login.php?error=AccessDenied");


}
?> -->

</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    position: fixed;
	    top:0;
	    left: 0
	    /*background: #007bff;*/
	}
	main#main{
		width:100%;
		height: calc(100%);
		display: flex;
	}

</style>




<body class="bg-whisper">  

  <main id="main" >  

  <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 px-lg-5">
            <a href="index.php" class="navbar-brand ml-lg-3">
                <h3 class="m-0 text-uppercase text-primary"><i class="fa fa-book-reader mr-3"></i>SETI</h3>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
                <div class="navbar-nav mx-auto py-0">
                    <a href="index.html" class="nav-item nav-link active" style='font-size:20px;'>Home</a>
                    <a href="about.html" class="nav-item nav-link" style='font-size:20px;'>About</a>
                    <!-- <a href="#content" class="nav-item nav-link">Content</a> -->
                    <!-- <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu m-0">
                            <a href="detail.html" class="dropdown-item">Content Detail</a>
                        </div>
                    </div> -->
                    <a href="contact.html" class="nav-item nav-link" style='font-size:20px;'>Contact</a>  
                    <!-- <a href="feedback.php" class="nav-item nav-link">Feedback</a>   -->
                </div>
               <div>  <a href="login.php" class="btn btn-primary py-2 px-4 d-none d-lg-block">Login</a></div>&ensp;
              <!-- <div>  <a href="adminlog.php" class="btn btn-primary py-2 px-4 d-none d-lg-block">Admin</a></div>-->
              
                
            </div>
        </nav>
    </div>
	
  <!-- <div> &ensp;&ensp;&ensp; <a href="login1.php" class="btn btn-primary py-2 px-4 d-none d-lg-block ">Home</a></div> -->
  		<div class="align-self-center w-100"> 
		<h4 class="text-white text-center"><b>Login</b></h4>
  		<div id="login-center" class="bg-whitesmoke row justify-content-center">
  			<div class="col-lg-11  bg-light blue col-md-3">
  				<div class="card-body">
  					<form id="login-form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
  						<div class="form-group">
  							<label for="email" class="control-label text-dark">Email</label>
  							<input type="text" id="email" name="email" class="form-control form-control-sm">
  						</div>
  						<div class="form-group">
  							<label for="password" class="control-label text-dark">Password</label>
  							<input type="password" id="password" name="password" class="form-control form-control-sm">
  						</div>
  						<center><button name="log" class="btn-sm btn-block btn-wave col-md-4 btn-primary">Login</button></center><br>
						  <p>Don't have an account? <a href="new_user.php">Sign up</a>
						  <!-- <a href="./new_user.php?page=new_user" class="nav-link nav-new_user tree-item"> <p>Add New</p> </a>
  					 -->
						</form>
  				</div>
  			</div>
  		</div>
  		</div>
  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>

<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.href ='index.php?page=home';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
	$('.number').on('input',function(){
        var val = $(this).val()
        val = val.replace(/[^0-9 \,]/, '');
        $(this).val(val)
    })
</script>	
</html>
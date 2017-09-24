<?php
session_start();
include('header/styles.php');
require ("include/include.php");
if(isset($_SESSION['username']))
{
  header("location:dashboard.php");
}
?>

<?php
if (isset($_POST['submit']))
	{
		$username = mysqli_real_escape_string($mysqli, $_POST['username']);
		$password = mysqli_real_escape_string($mysqli, $_POST['password']);
		$query = "SELECT * FROM users where username = '$username' and password = '$password'";
		$run_query = mysqli_query($mysqli, $query);
		$count = mysqli_num_rows($run_query);
		if($count == 1)
			{
			  $data = mysqli_fetch_assoc($run_query);
			  $_SESSION['username'] = $username;
			  $_SESSION['password'] = $password;
			  //$_SESSION['user_type'] = $data['user_type'];
			  header('location:dashboard.php');
			}		
				else
					{
					  echo "<div class='alert alert-dismissable alert-danger'>
								<center><i class='fa fa-fw fa-times'></i>&nbsp; <strong>ERROR!</strong> INCORRECT USERNAME OR PASSWORD</center>
							</div>";
					}

	}
 ?>
     <title>Login</title>
 <body class="focused-form">
 <style>
 body{
 	 background: url('img/iceland.jpg') no-repeat; 
 }
 a:hover{
 	text-decoration: none;
 	color: #ccc;
 }
 .smart{
 	background-color: #eeeeee;
 	border: #e0e0e0;
 	height: 80px;
 	width: 31.85%;
	border-top-right-radius: 10px; 	
	border-top-left-radius: 10px; 	
 	margin: auto;

 }
 </style>       
<div class="container" id="login-form">
	<div class="smart">
	<center>
		<a href="sellerlogin.php" class="login-logo"><img src="img/animated.gif" height="60" width="60" ></a>
		</center>
	</div>
	<center>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">
				<center><h5>SELLERS LOGIN</h5></center>
				</div>
				<div class="panel-body">
					
					<form action="" method="POST" class="form-horizontal" id="validate-form">
						<div class="form-group">
	                        <div class="col-xs-12">
	                        	<div class="input-group">							
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
									<input type="text" class="form-control" name="username" placeholder="username"  required>
								</div>
	                        </div>
						</div>
<br>
						<div class="form-group">
	                        <div class="col-xs-12">
	                        	<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-key"></i>
									</span>
									<input type="password" class="form-control " name="password"  placeholder="Password" required>
								</div>
	                        </div>
						</div>

						<div class="panel-footer">
							<div class="clearfix">

<!-- 								<a href="index.php">
									<input type="button" value="Home" class="btn btn-default pull-left">
								</a> -->
								<br>
								<input type="submit" name="submit" value="Login" class="btn btn-primary pull-right" />
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

    </center>
    
    <!-- Load site level scripts -->

<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script> -->


<?php 
include('header/script.php');
 ?>
<!-- End loading site level scripts -->
    <!-- Load page level scripts-->
    

    <!-- End loading page level scripts-->
    </body>

<!-- Mirrored from avenger.kaijuthemes.com/extras-login.html by HTTrack Website Copier/3.x [XR&CO'2013], Wed, 02 Dec 2015 04:47:46 GMT -->
</html>
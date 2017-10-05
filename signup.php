<?php 
session_start();
$connection =  include_once('resources/conection.inc.php');


if(isset($_POST['submit'])){
	$username = htmlentities($_POST['username']);
	$username = strtoupper(mysqli_real_escape_string($connection,$username));
	$password1 = htmlentities($_POST['password1']);
	$password1 = strtoupper(mysqli_real_escape_string($connection,$password1));
	
	$password2 = htmlentities($_POST['password2']);
	$password2 = strtoupper(mysqli_real_escape_string($connection,$password2));
    $date_created  =date('Y/m/d');
	//$date_created = htmlentities($_POST['date_created']);
	//$date_created = strtoupper(mysqli_real_escape_string($connection,$date_created));


	if($password1 != $password2){
		 $_SESSION['match_error'] = 'error';
	}else{

		$query = "INSERT INTO users (username,password,date_created) 
		VALUES ('$username' , '$password1' ,'$date_created')";

		if (mysqli_query($connection, $query)) {
			header("location:index.php");
		}else{
			printf("Notice: %s", mysqli_error($mysqli));
		}

	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>ALHAJI-OWODE-PAGE</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="css/AdminLTE.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="plugins/iCheck/square/blue.css">

	<link rel="stylesheet" href="css/animate.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
  	folder instead of downloading all of them to reduce the load. -->
  	<link rel="stylesheet" href="css/skins/_all-skins.min.css">

  	<style type="text/css">

  	.center-div{
  		margin-top:10%;
  	}

  	input {
  		text-transform: uppercase;
  	}

  	.curved{
  		border-radius: 5px;
  	}
    .blue-link{

    }
  </style>

</head>
<header class="main-header">
	<!-- Logo -->
	<a href="../../index2.html" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><b>A</b>LT</span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><b>Admin</b>LTE</span>
	</a>
	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</a>

		<div class="navbar-custom-menu">

		</div>
	</nav>
</header>
<body class="hold-transition register-page" style="background-color: rgb(248,248,248)">

	

	<div class="register-box ">
		<div class="register-logo" style="background-color: rgb(248,248,248); font-family: pacifico">
			Registration
		</div>

		<div class="register-box-body curved">
			<p class="login-box-msg"></p>

			<form action=" <?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

				<div class="form-group  ">
					<input type="text" class="form-control" name="username" placeholder="your username" autocomplete="off"  autofocus="false" required>
					
				</div>

				<div class="form-group  pword">
					<input type="Password" autocomplete="off" class="form-control" name="password1" 
					placeholder="your password" autofocus="false" id = 'pword1' required>
					
				</div>

				<div class="form-group  pword">
					<input type="Password" autocomplete="off" class="form-control" name="password2" 
					placeholder="retype password" autofocus="false" id = 'pword2' required>

				</div>


				<!-- /.col -->
				<div class="form-group">
					<input type="submit" name="submit" value="Register" class="btn btn-primary  btn btn-block  btn-primary" id  = 'submit'><br>
					<small class = 'blue-link'><a href = 'index.php'>I already has an account</a></small>
				</div>

				<!-- /.col -->

			</form>
		</div>
		<br>

	</div>
	<!-- /.form-box -->
	<!-- /.register-box -->

	<!-- jQuery 2.2.3 -->
	<script src="js/jquery-2.2.3.min.js"></script>
	<!-- Bootstrap 3.3.6 -->
	<script src="js/bootstrap.min.js"></script>
	<!-- iCheck -->
	<script src="../plugins/iCheck/icheck.min.js"></script>
	<script>
		$('document').ready(function () {
			var error  = "<span class='help-block'>Passwords Do not match</span>";
              $('input').click(function(){
              	  $('.pword').removeClass('has-error');
              	  $('.help-block').slideUp();
              })
			<?php
             
			if(isset($_SESSION['match_error'])){
				echo "console.log('pworderr');";
				echo "$('.pword').addClass('has-error');";
				echo "$('.pword').append(error);";
				unset($_SESSION['match_error']);
			}
			?>
		});
	</script>
</body>
</html>
<?php session_start();

if(!isset($_SESSION['user'])){
	header("Location: ../");
}

$connection =  include_once('resources/conection.inc.php');

$user_data  = unserialize($_SESSION['user']);
$username = $user_data['username'];
$user_id = $user_data['id'];


if(isset($_POST['submit'])){
	$password1 = htmlentities($_POST['password1']);
	$password1 = strtoupper(mysqli_real_escape_string($connection,$password1));
	
	$password2 = htmlentities($_POST['password2']);
	$password2 = strtoupper(mysqli_real_escape_string($connection,$password2));

	$should_change_password = true;


	if($password1 == $password2){
	
		if (strlen($password1) < 5) {
			$_SESSION['password_len'] = 'error';
			$should_change_password = false;
		}

	}else{
		$_SESSION['match_error'] = 'error';
		$should_change_password = false;
	}

	

	if ($should_change_password){
		if(changePassword($connection,$user_id,$password1)){
			$_SESSION['done'] = 'done';
		}else{
			printf("Notice: %s", mysqli_error($mysqli));
		}
	}
}


function changePassword($connection,$user_id,$new_password){ 
	$query = "UPDATE users SET password = '$new_password' WHERE id = '$user_id'";
	if (mysqli_query($connection,$query)){
		return true;
	}else {
		return false;
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>MUKAZ | Change Password</title>
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

	<link rel="stylesheet" href="css/native-toast.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="plugins/iCheck/square/blue.css">

	<script type="text/javascript" src = 'js/native-toast.js'></script>

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
	<a href="sales/sell.php" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<!-- <span class="logo-mini"><b>A</b>LT</span> -->
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><b>MUKAZ NG.</b>LTD</span>
	</a>
	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top">
		<div class="navbar-custom-menu">

		</div>
	</nav>
</header>
<body class="hold-transition register-page" style="background-color: rgb(248,248,248)">

	

	<div class="register-box ">
		<div class="register-logo" style="background-color: rgb(248,248,248); font-family: pacifico">
			<?= $username?>
		</div>

		<div class="register-box-body curved">
			<p class="login-box-msg"></p>

			<form action=" <?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

				<div class="form-group  pword">
					<input type="Password" autocomplete="off" class="form-control" name="password1" 
					placeholder="new password" autofocus="false" id = 'pword1' required>
					
				</div>

				<div class="form-group  pword">
					<input type="Password" autocomplete="off" class="form-control" name="password2" 
					placeholder="retype password" autofocus="false" id = 'pword2' required>

				</div>


				<!-- /.col -->
				<div class="form-group">
					<input type="submit" name="submit" value="Save Changes" class="btn btn-primary  btn btn-block  btn-primary" id  = 'submit'><br>
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

			function showToast(type, message){
				var useEdge = true;
				var useDebug = false;

				nativeToast({
					message: message,
					square: true,
					edge: useEdge,
					debug: useDebug,
					type : type 
				});
			}

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

			}elseif (isset($_SESSION['done'])) {
				echo "showToast('success', 'You Have Successfully Changed Your Password')";
				unset($_SESSION['done']);

			}elseif (isset($_SESSION['password_len'])) {
				echo "showToast('error', 'You Password Length is Invalid, It Must Not Be Less Than 5')";
				unset($_SESSION['password_len']);
			}
			?>
		});
	</script>
</body>
</html>
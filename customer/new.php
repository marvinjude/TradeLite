<?php session_start();

if(!isset($_SESSION['user'])){
  header("Location: ../");
}

$connection = include('../resources/conection.inc.php');
if (isset($_POST['new_customer'])){
	$customer_name = trim(mysqli_real_escape_string($connection, htmlentities($_POST['customer_name'])));
	$customer_phone = mysqli_real_escape_string($connection, htmlentities($_POST['customer_phone']));
	$customer_address = mysqli_real_escape_string($connection, htmlentities($_POST['customer_address']));
	$date_created = date('Y/m/d');

	if(!phone_exist($customer_phone)){
//$_SESSION['invalid_phone'] = 'error';
		$query = "INSERT INTO customers (customer_name, customer_phone, address, date_created ) 
		VALUES ('$customer_name', '$customer_phone' ,'$customer_address', '$date_created')";


		if (mysqli_query($connection, $query)) {
			$_SESSION['customer_create_success'] = "success";
		} else{
			$_SESSION['create_stock_error'] = 'error';
			trigger_error('Error: '. mysqli_error($connection));
		}

	}else{
		$_SESSION['phone_exist_error'] = 'error';
	}


}

function phone_exist($phone){
	global $connection;
	$query = "SELECT * FROM customers WHERE customer_phone = '$phone' ";
	if ($result = mysqli_query($connection,$query)){


		mysqli_num_rows($result);


		if (mysqli_num_rows($result) > 0) {
			return true;
		}else{
			return false;
		}
	}else{
		trigger_error("Error: " . $query . "<br>" . mysqli_error($connection));
	}
}







?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>MUKAZ | New Customer</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<!-- Ionicons -->

	<!-- Theme style -->
	<link rel="stylesheet" href="../css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">

  <link rel="stylesheet" href="../css/animate.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="../plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <link rel="stylesheet" href="../css/ionicons.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style type="text/css">
  	.edit{
  		cursor: pointer;
  		padding:10px;
  	}

  	input,select{text-transform: uppercase;}
  </style>

</head>

<body>

	<body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">



			<!-- header  -->
			<?php  include('../resources/templates/header.php') ; ?>
			<!-- end header   -->


			<!-- Left side column. contains the logo and sidebar -->
			<?php  include('../resources/templates/mainsidebar.php') ; ?>

			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">



				<section class="content-header " style="border-bottom:2px solid skyblue">
					<h1 >
						Create New Customer
					</h1>
					<br>       
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">Customer</a></li>
						<li class="active">New</li>
					</ol>
				</section>


				<div class="container">
					<div class="row">
						<div class="col-md-7 col-md-offset-2 ">
							<hr>

							<section class="content">

								<div class="box box-default">
									<div class="box-header with-border">
										<h3 class="box-title"> New Customer Form</h3>

										<div class="box-tools pull-right">
											<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
											<button type="button"  name = 'newstock' class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
										</div>
									</div>
									<!-- /.box-header -->
									<div class="box-body">
										<div class="row">

											<div class="col-md-10">
												<?php
												$alert ="<div class='alert  alert-success alert-dismissible animated slideInLeft'>
												<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
												<i class='glyphicon glyphicon-ok'></i> Customer Created
											</div>";

											$alert2 ="<div class='alert  alert-danger alert-dismissible animated slideInLeft'>
											<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
											<i class='glyphicon glyphicon-ban-circle'></i>Invalid Phone Number
										</div>";

										$alert3 ="<div class='alert  alert-danger alert-dismissible animated slideInLeft'>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
										<i class='glyphicon glyphicon-ban-circle'></i>Error -This Phone Number Belongs to a previous Customer
									</div>";

									if(isset($_SESSION['customer_create_success'])){
										echo $alert;
										unset($_SESSION['customer_create_success']);
									}elseif (isset($_SESSION['invalid_phone'])) {
										echo $alert2;
									}elseif (isset($_SESSION['phone_exist_error'])) {
										echo $alert3;
										unset($_SESSION['phone_exist_error']);
									}




									?>

								</div>

								<div class="col-md-12">
									<form method="POST" action = "<?php echo $_SERVER['PHP_SELF']?>">
										<div class="form-group">

											<div class="form-group">
												<label>Customer Name</label>
												<input type="text" name = 'customer_name' class="form-control" placeholder="Enter Customer Name" required>
											</div>

											<!-- /.form-group -->
											<div class="form-group">
												<label> Phone</label>
												<input name = 'customer_phone' type="number" class="form-control" placeholder="Enter Customer Number" id = 'phone' 
												 pattern="[0-9]{11}" >
											</div>

											<div class="form-group">
												<label> Address</label>
												<input name = 'customer_address' type="text" class="form-control" placeholder="Enter Customer Address" >
											</div>

											<!-- /.form-group -->
											<input type="submit" name = 'new_customer' class="btn btn-primary pull-right" value = "Create Customer"> </button>
										</form>
									</div>
									<!-- /.col -->

									<!-- /.col -->
								</div>
								<!-- /.row -->
							</div>
							<!-- /.box-body -->
          <!-- <div class="box-footer">
            Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
            the plugin.
        </div> -->
    </div>











</div>
</div>





<script src="../js/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../js/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script> 
<script type="text/javascript">
	<?php
	if (isset($_SESSION['invalid_phone'])){
		echo " $('document').ready(function(){
			$('#phone').css('border', '1px solid red');
		});";   

		unset($_SESSION['invalid_phone']);
	}


	?>

	$('document').ready(function(){
		setTimeout(function(){ $('.alert').fadeOut()},3000);
	});
</script>

</body>
</html>



























<?php
session_start();
$connection = include('../resources/conection.inc.php');

// customer=10+-+JUDE+-+098888678&customer_phone=888&customer_address=2017-09-02&create_deposit=Deposit

if (isset($_POST['create_deposit'])){
	if($_POST['customer'] != ''){
	$customer_id  = fetch_id($_POST['customer']);
	$amount_deposited = mysqli_real_escape_string($connection, htmlentities($_POST['amount_deposited']));
	$date_created = mysqli_real_escape_string($connection, htmlentities($_POST['date_created']));

	$query = "INSERT INTO customer_deposits (customer_id,amount_deposited,date_deposited) VALUES ('$customer_id','$amount_deposited','$date_created')";
	if(mysqli_query($connection,$query)){
		$_SESSION['deposit_created'] = 'success';
	}else{
		$_SESSION['deposit_create_error'] = 'error';
	}


}else{
	$_SESSION['select_a_customer'] = 'error';
}

}

function fetch_id($form_customer_selction){
	$data = explode('-',$form_customer_selction);
	return trim($data[0]);
}

function get_all($table){
	global $connection;
	$all_data = array();
	$query = "SELECT * FROM $table";
	if ($result = mysqli_query($connection,$query)){

		for($i = 0; $i< mysqli_num_rows($result); $i++){
			array_push($all_data, mysqli_fetch_assoc($result));
		}

	}else{
		trigger_error(mysqli_error($connection));
	}
	return $all_data;

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
	<title>AdminLTE 2 | General Form Elements</title>
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

  	<link rel="stylesheet" href="../plugins/select2/select2.min.css">
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
						Create New Customer Deposit
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
						<div class="col-md-8 col-md-offset-1 ">
							<hr>

							<section class="content">

								<div class="box box-default">
									<div class="box-header with-border">
										<h3 class="box-title"> Customer Deposit Form</h3>

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
												<i class='glyphicon glyphicon-ok'></i> Deposit Created Successfully
												</div>";

												$alert2 ="<div class='alert  alert-danger alert-dismissible animated slideInLeft'>
												<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
												<i class='glyphicon glyphicon-ban-circle'></i> Unable to Create Deposit - Please select a Customer 
												</div>";


												if(isset($_SESSION['deposit_created'])){
													echo $alert;
													unset($_SESSION['deposit_created']);

												}elseif (isset($_SESSION['select_a_customer'])) {
													unset($_SESSION['select_a_customer']);
													echo $alert2;
												}




												?>

											</div>

											<div class="col-md-12">
												<form method="POST" action = "<?php echo $_SERVER['PHP_SELF']?>">
													<div class="form-group">

														<div class="form-group">
															<label>Customer</label>
															<select class="form-control select2" style=" width: 100%;"
															name = "customer" >
															<option></option>
															<?php $all_data = get_all('customers')?>
															<?php foreach ($all_data as $row): ?>
																<option>
																	<?= $row['id']. " - ".strtoupper($row['customer_name']) . " - ".$row['customer_phone']?>
																</option>
															<?php endforeach ?>
														</select>
													</div>

													<!-- /.form-group -->
													<div class="form-group">
														<label> Amount Deposited</label>
														<input type="number" class="form-control" placeholder="Enter Customer Number" name = "amount_deposited"
														pattern="[0-9]{11}"  required>
													</div>

													<div class="form-group">
														<label> Date</label>
														<input  type="date" class="form-control" placeholder="Enter Customer Address" name = "date_created" required>
													</div>

													<!-- /.form-group -->
													<input type="submit" name = 'create_deposit' class="btn btn-primary pull-right" value = "Deposit"> </button>
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

<script src="../plugins/select2/select2.min.js"></script>
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
		$('.select2').select2();

	});
</script>

</body>
</html>



























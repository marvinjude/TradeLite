<?php session_start();

if(!isset($_SESSION['user'])){
  header("Location: ../");
}

$connection = include('../resources/conection.inc.php'); 

if (isset($_POST['balance_submit'])){
	$amount = mysqli_real_escape_string($connection, htmlentities($_POST['amount']));
	$date = mysqli_real_escape_string($connection, htmlentities($_POST['date']));
	//$date = date('Y/m/d');
	//$last_receive_date  =date('Y/m/d');
	$query = "INSERT INTO balance_brought_foward (amount, date) 
	VALUES ('$amount' , '$date')";

	if (mysqli_query($connection, $query)) {
		$_SESSION['bbf_create_success'] = "success";
	}else{
		echo mysqli_error($connection);
	}
}


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>MUKAZ | New Balance Brought Forward</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<!-- <link rel="stylesheet" href="css/font-awesome.min.css"> -->
	<!-- Ionicons -->
	<link rel="stylesheet" href="../css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="../css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
  	folder instead of downloading all of them to reduce the load. -->
  	<link rel="stylesheet" href="../css/skins/_all-skins.min.css">
  	<!-- iCheck -->
  	<link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
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

  	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
input{
	text-transform: uppercase;
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
				<section class="content-header">
					<h1>
						<b>Balance Brought Forward</b>
					</h1>
					<hr>         
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">pnb</a></li>
						<li class="active">view</li>
					</ol>
				</section>

				<div class="container">
					<div class="row">
						<div class="col-md-10 ">

							<section class="content">

								<div class="box box-default">
									<div class="box-header with-border">
										<h3 class="box-title">Balance forward</h3>
									</div>
									<!-- /.box-header -->
									<div class="box-body">
										<div class="row">
											<div class="col-md-12">
												<?php
												$alert ="<div class='alert  alert-success alert-dismissible animated slideInLeft'>
												<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
												<i class='glyphicon glyphicon-ok'></i> Successful
												</div>";

												if(isset($_SESSION['bbf_create_success'])){
													echo $alert;
													unset($_SESSION['bbf_create_success']);
												}
												?>

												<form method="POST" action = "<?php echo $_SERVER['PHP_SELF'];?>">
													<div class="form-group">

														<div class="form-group">
															<label>Amount</label>
															<input type="number" name = 'amount' class="form-control" placeholder="Amount" required>
														</div>

														<!-- /.form-group -->
														<div class="form-group">
															<label>Date</label>
															<input name = 'date' type="date" class="form-control" required>
														</div>

														<!--date created-->

                       <!-- <div class="form-group">
                          <label>Date Created</label>
                          <input name = 'expense_date' type="date" class="form-control" placeholder="Enter created date" required>
                      </div>-->
                      <!-- /.form-group -->
                      <input type="submit" name = 'balance_submit' class="btn btn-primary pull-right" value = "save balance">
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

</section>
</div>
</div>
</div>
</form>
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
</body>

<script type="text/javascript">

	$('document').ready(function(){
		setTimeout(function(){ $('.alert').fadeOut()},3000);
	});

</script>
</html>

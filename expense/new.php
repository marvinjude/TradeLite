<?php session_start();

if (!isset($_SESSION['user'])){
  header("Location : ../index.php");
}

$connection = include('../resources/conection.inc.php');
//session_start();
//ob_start();
//echo stockexist('10MM');
if (isset($_POST['expense_submit'])){
  $expense_description = trim(mysqli_real_escape_string($connection, htmlentities($_POST['expense_description'])));
  $expense_amount = mysqli_real_escape_string($connection, htmlentities($_POST['expense_amount']));
  $expense_date = mysqli_real_escape_string($connection, htmlentities($_POST['expense_date']));

    $query = "INSERT INTO expenses(expense_description, expense_amount, expense_date) 
    VALUES ('$expense_description' , '$expense_amount', '$expense_date')";

    //echo $querY
    $result = mysqli_query($connection, $query);
    if($result){
      echo "recored created";
    }else{
      echo "not created ".mysqli_error($connection);
    }
}
    
?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MUKAZ | New Expense </title>
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
        <section class="content-header">
          <h1>
            Create Expense
          </h1>
          <hr>         
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Post Expense</a></li>
            <li class="active">View Expense</li>
          </ol>
        </section>
        
        
        <div class="container">
          <div class="row">
            <div class="col-md-10 ">

              <section class="content">

               <div class="box box-default">
                <div class="box-header with-border">
                  <h3 class="box-title"> Create New Expense</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button"  name = 'newstock' class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                  <div class="col-md-12">
                  
                    <form method="POST" action = "<?php echo $_SERVER['PHP_SELF'];?>">
                      <div class="form-group">

                        <div class="form-group">
                          <label>New Expense</label>
                          <input type="text" name = 'expense_description' class="form-control" placeholder="Enter new expense name" required>
                        </div>

                        <!-- /.form-group -->
                        <div class="form-group">
                          <label>Amount</label>
                          <input name = 'expense_amount' type="number" class="form-control" placeholder="Enter The Amount" required>
                        </div>

                        <!--date created-->

                        <div class="form-group">
                          <label>Date Created</label>
                          <input name = 'expense_date' type="date" class="form-control" placeholder="Enter created date" required>
                        </div>
                        <!-- /.form-group -->
                        <input type="submit" name = 'expense_submit' class="btn btn-primary pull-right" value = "Save expense">
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
</html>

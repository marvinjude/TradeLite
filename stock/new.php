<?php session_start();
$connection = include('../resources/conection.inc.php');

if(!isset($_SESSION['user'])){
  header("Location: ../");
}
$user_data = unserialize($_SESSION['user']);

if($user_data['type'] !== '2'){
    echo '<h1>You Cannot Access This Page Pls Exit This Page As Quick As Possible!</h1>';
    die();
}


if (isset($_POST['newstock'])){
  $description = trim(mysqli_real_escape_string($connection, htmlentities($_POST['description'])));
  //preg_match('^[0-9]{2} \s[a-zA-Z]{2} ', $description)
  $cost_per_ton = mysqli_real_escape_string($connection, htmlentities($_POST['cost_per_ton']));
  $date_created = date('Y/m/d');
  $last_receive_date  =date('Y/m/d');



  if (!stockexist($description)){

    $query = "INSERT INTO stocks (description, cost_per_ton, date_created, last_receive_date ) 
    VALUES ('$description' , '$cost_per_ton', '$date_created' , '$last_receive_date')";

    //echo $query;

    if (mysqli_query($connection, $query)) {

      $_SESSION['create_stock_success'] = "success";
    } else {
      echo "Error: " . $query . "<br>" . mysqli_error($mysqli);
    }

  }else{
    $_SESSION['create_stock_error'] = 'error';
  }

}



function stockexist($description){
  global $connection;
  $query = "SELECT * FROM stocks WHERE description = '$description' ";
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
  <title>MUKAZ | New Stock</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../css/font-awesome.min.css"> 
  <!-- Ionicons -->
  <link rel="stylesheet" href="../css/ionicons.min.css">
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

  <!-- Daterange picker -->

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
            New Stock
          </h1>
          <hr>         
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Stock</a></li>
            <li class="active">Receive</li>
          </ol>
        </section>
        
        
        <div class="container">
          <div class="row">
            <div class="col-md-10 ">

              <section class="content">

               <div class="box box-default">
                <div class="box-header with-border">
                  <h3 class="box-title"> Create New Stock</h3>

              
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row">

                    <?php

                    $alert_error =  "<div class='alert  alert-danger alert-dismissible animated bounce'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h4><i class='icon fa fa-ban'></i> This Stock Already Exist!</h4>
                    Sorry you can't create stock that already exists- make sure the product you are creating 
                  </div>";
                   
                   $alert_success = "<div class='alert  alert-success alert-dismissible animated bounce'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h4><i class='icon fa fa-ban'></i> Stock Created Successfully</h4>
                  </div>";

                  if(isset($_SESSION['create_stock_error']) &&!empty($_SESSION['create_stock_error'])){
                    echo $alert_error;
                    unset($_SESSION['create_stock_error']);
                  }elseif (isset($_SESSION['create_stock_success'])) {
                    echo $alert_success;
                    unset($_SESSION['create_stock_success']);
                  }

                  ?>



                  <div class="col-md-12">
                    <form method="POST" action = "<?php echo $_SERVER['PHP_SELF']?>">
                      <div class="form-group">

                        <div class="form-group">
                          <label>Stock Decription</label>
                          <input type="text" name = 'description' class="form-control" placeholder="Enter Stock Description and Type" required>
                        </div>

                        <!-- /.form-group -->
                        <div class="form-group">
                          <label>Cost per ton</label>
                          <input name = 'cost_per_ton' type="number" class="form-control" placeholder="Enter The Price per ton" required>
                        </div>

                        <!-- /.form-group -->
                        <input type="submit" name = 'newstock' class="btn btn-primary pull-right" value = "Create New Stock"> </button>
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
  
  $('document').ready(function(){
    setTimeout(function(){ $('.alert').fadeOut()},3000);
  });


  
</script>
</body>
</html>

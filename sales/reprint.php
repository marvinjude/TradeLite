<?php session_start();

if (!isset($_SESSION['user'])){
  header("Location : ../index.php");
}

$connection = include('../resources/conection.inc.php');
include_once('../functions/invoice_functions.php');

if (isset($_POST['submit'])){
  $invoice_num = trim($_POST['invoice_num']);
  $invoice_num = mysqli_real_escape_string($connection, $invoice_num);
  $invoice_num  = htmlentities($invoice_num);
  $sale_id = getSaleId($invoice_num,$connection);

  if($sale_id == ''){
   $_SESSION['error_invoice_num'] = $invoice_num;

 }else{
  header("Location: invoice.php?id=".$sale_id);
}
}



?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MUKAZ | Reprint Invoice</title>
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

  </head>
  <style type="text/css">
  .center-div{
    margin-top:10%;
  }

  .center-text{
    text-align: center;
  }
  .active-color{
    background-color: #3c8dbc;
    color:white;
  }
  .active-color:hover{
    background-color: #3c8dbc;
    color:white;
  }

</style>
<body>

  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">



      <!-- header  -->
      <?php  include('../resources/templates/header.php') ; ?>
      <!-- end header   -->


      <!-- Left side column. contains the logo and sidebar -->
      <?php  include('../resources/templates/mainsidebar.php') ; ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" style="background-color: white">

        <div class="container">
          <div class="row">
            <div class="col-md-10 col-md-offset-1 ">

              <section class="content">
                <form method = 'POST' action = <?php echo $_SERVER['PHP_SELF']?>>
                  <div class ="jumbotron center-div bg-success">
                    <h1 class = 'center-text'> <!-- <i class = 'glyphicon glyphicon-list-alt' ></i> -->Re-print Invoice. </h1><br>
                    <div class = ' form-group' >
                      <input type="number" 
                      placeholder = "Enter Invoice Number"   name = 'invoice_num' class='form-control input-lg' required = 'true' id  ='invoice_num'>
                      


                      

                      <br>

                      <input value = 'Find Invoice' type="submit" name="submit" class = 'btn btn-lg active-color btn-block' >
                    </div>
                  </div>
                </form>
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

    <script type="text/javascript">

      var error = "<span class='help-block'>Invoice Number &nbsp<small class='label bg-red'>"
        + <?php echo $_SESSION['error_invoice_num'] ?>  + "</small> Does Not Exist</span>";


      $('#invoice_num').on('click',function(){
       $('.form-group').find('span').slideUp();
       $('.form-group').removeClass('has-error');
     });

      <?php

      if(isset($_SESSION['error_invoice_num'])){
        echo "$('#invoice_num').after(error);
        $('.form-group').addClass('has-error');";
        unset($_SESSION['error_invoice_num']);
      }

      ?>

    </script>
  </body>
  </html>

<?php

$connection = include('../resources/conection.inc.php');


if(isset ($_POST['receive_stock'])){
  $quantity_received = $_POST['quantity_received'];
  $quantity_received = mysqli_real_escape_string($connection,htmlentities($quantity_received));

  $productdescription = $_POST['stock_selected'];
  $productdescription = mysqli_real_escape_string($connection,htmlentities($productdescription));


  $previous_quantity = get('stocks','quantity_in_store',
    array('field' => 'description',
      'value' => $productdescription
      ))[0]['quantity_in_store'];

  $new_quantity = $previous_quantity + $quantity_received;

  if (update('stocks','quantity_in_store',$new_quantity,
    array("field"=> 'description',
      "value"=> $productdescription
      ))){
         $_SESSION['receive_stock_success'] = 'success';
  }
//$table,$field,$newvalue,$selection_condition = array()



}



function get($table,$field,$where){
  global $connection;
  $data = array();
  $condition = (object)$where;
  $query = "SELECT $field FROM $table". " WHERE ". $condition->field . ' = ' . 
  "'". $condition->value. "'";
  $query;
  if($result = mysqli_query($connection,$query)){

    for($i = 0; $i< mysqli_num_rows($result); $i++){
      array_push($data, mysqli_fetch_assoc($result));
    }
    return $data;
  } else{
    trigger_error('Error: '. mysqli_error($connection));
    return false;
  }
}


function get_all_options(){
  global $connection;
  $query = "SELECT description FROM stocks";

  if ($result = mysqli_query($connection,$query)){
    $options  ="-";
    while ($row = mysqli_fetch_assoc($result)){
     $options .="<option>". "<br>";
     $options .= $row['description'];
     $options .= "</option>";
           // echo $row['description']
   }

   return $options;

 }




}

function update($table,$field,$newvalue,$selection_condition = array()){
  global $connection;
  $selection_condition = (object)$selection_condition;

   $query = "UPDATE  $table SET $field = $newvalue WHERE 
  $selection_condition->field ='$selection_condition->value'  ";
  if (mysqli_query($connection,$query)){
    return true;
  }else{
    trigger_error("error: " . mysqli_error($connection));
    return false;
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
  <!-- <link rel="stylesheet" href="css/font-awesome.min.css"> -->
  <!-- Ionicons -->

  <link rel="stylesheet" href="../css/animate.min.css">

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
  <script src="https://oss.maxcdnfform.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

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
            Receive Stocks
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
                  <h3 class="box-title">Select2</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <form action = <?php echo $_SERVER['PHP_SELF']?> method = "POST">

                  <div class="box-body">
                    <div class="row">
                     <div class="col-md-4">
                  <?php
                    $alert = "<div class='alert  alert-success alert-dismissible animated slideInLeft'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h4><i class='icon fa fa-ban'></i> Stock Received</h4>";

                    if(isset($_SESSION['receive_stock_success'])){
                      echo $alert;
                      unset($_SESSION['receive_stock_success']);
                    }
                  ?>
                  </div>
                  </div>

                      <div class="col-md-12">

                        <div class="form-group">
                          <label>Select Product</label>
                          <select  name = 'stock_selected' class="form-control select2" style="width: 100%;">
                            <?php 
                            echo get_all_options();
                            ?>
                          </select>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                          <label>Quantity Received</label>
                          <input type="number" class="form-control" name = 'quantity_received' placeholder="Enter No.Of Quantity Received For This Stock">
                        </div>
                        <!-- /.form-group -->


                        <input name = 'receive_stock' type="submit" class="btn btn-primary pull-right" value = 'update'> 

                      </div>
                      <!-- /.col -->

                      <!-- /a.col -->
                    </div>
                    <!-- /.row -->
                  </div>
                  <!-- /.box-body -->  
                </form>
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
<script src="js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="js/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script> 
<script type="text/javascript">
    $('document').ready(function(){
    setTimeout(function(){ $('.alert').fadeOut()},3000);
  });

</script>
</body>
</html>

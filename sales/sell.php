<?php session_start();

include_once '../functions/invoice_functions.php';
$connection = include('../resources/conection.inc.php');


if (!isset($_SESSION['user']) ){
  header("Location: ../index.php");
}

if(isset($_GET['cid'],$connection)){
  if(isValidCustomer($_GET['cid'],$connection)){
   $_SESSION['customer_id'] = (int)trim($_GET['cid']);
 }
}


//if previous stocks were stored in the session go ahead and delete them
if(isset($_SESSION['sales'])){
  unset($_SESSION['sales']);
  unset($_SESSION['last_sale_id']);
}

$_SESSION['sale_date'] = date('Y-m-d');
$_SESSION['invoice_number'] = genNewInvoiceNumber($connection);

    //var_dump($_SESSION);

function get_all($table,$connection){
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

function isValidCustomer($id,$con){
 $query = "SELECT * FROM customers WHERE id = $id" ;
 if($result = mysqli_query($con,$query)){
   if(mysqli_num_rows($result) == 1){
    return true;
  }
  return false;
}
}  
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> MUKAZ | Sell</title>
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

  <link rel="stylesheet" href="../css/native-toast.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
      folder instead of downloading all of them to reduce the load. -->
      <link rel="stylesheet" href="../css/skins/_all-skins.min.css">
      <!-- iCheck -->
      <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
      <!-- Morris chart -->
      <link rel="stylesheet" href="../plugins/morris/morris.css">

      <link rel="stylesheet" href="../plugins/select2/select2.min.css">

      <link rel="stylesheet" href="../css/animate.min.css">
      <!-- jvectormap -->
      <link rel="stylesheet" href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
      <!-- Date Picker -->
      <link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
      <!-- Daterange picker -->
      <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
      <!-- bootstrap wysihtml5 - text editor -->
      <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

      <link rel="stylesheet" type="text/css" href="../css/wave.css">
      <style type="text/css">
      .added-stock{
        background-color: whitesmoke;
        font-weight: bold;
      }
      .rounded{
        border-radius: 5px;
      }

      input,select{text-transform: uppercase;}

      .padd{
        padding: 5px;
      }
      #proceed a {
        color:white;
      }

      #confirm__supply__status{
        display: none;
      }
    </style>
  </head>


  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <!-- header  -->
      <?php  include('../resources/templates/header.php') ; ?>
      <!-- end header   -->


      <!-- Left side column. contains the logo and sidebar -->
      <?php  include('../resources/templates/mainsidebar.php') ; ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper ">
       <div class="container-fluid">

        <div class = 'row' style="margin-top:15px">
          <div class = 'col-md-8 no-padding'>
            <div class="container-fluid">
             <div class = 'row'>

              <div class = 'col-md-12'>
               <div class="box  box-solid">
                <div class="box-header bg-purple with-border">
                  <h4 class="box-title">Sales Information</h4>
                  <button type = 'button' class = 'close'></button>
                </div>
                <div class="box-body">
                  <!-- remove this -->
                  <div id = 'throwithere'></div>
                  <!-- remove this -->
                  <div class="row">

                   <div class="col-md-4 col-sm-4">
                    <div class="form-group">
                      <label>Customer</label>
                      <select id = 'customer' class="form-control select2 "
                      style=" width: 100%;"> 
                      <!-- get all customrer and render to html -->
                      <?php $customers = get_all('customers',$connection)?>
                      <option></option>
                      <?php foreach ($customers as $customer): ?>
                       <option id = '<?=$customer['id']?>' >
                        <?= $customer['customer_name'] ?>
                        (<?=$customer['customer_phone']?>)
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>

              <div class="col-md-4 col-sm-4">
                <label>invoice Number</label>
                <input class="form-control " type="number" name="invoice-number" id = "invoice-number"
                value = '<?=genNewInvoiceNumber($connection)?>'>
              </div>

              <div class="col-md-4 col-sm-10 col-xs-12" style="">
                <label>Sale Date</label>
                <input class="form-control " type="date" id="sale_date" 
                value= '<?= date('Y-m-d',strtotime('today'))?>'>
              </div>

            </div>

          </div>
          <!-- /.box-body -->
        </div>
      </div>

      <div class = 'col-md-12'>

       

        <div class="box  box-solid">

          <div class="box-header bg-purple with-border">
            <h4 class="box-title">Enter Each Stock Sold</h4>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form>
            <div class="box-body">
             <!-- <div class="alert alert-info animated slideInLeft">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
               <p>Enter Each Stocks Bought and proceed by clicking The Add button.</p>
             </div> -->
             <!-- stock -->
             <div class="row">
              <div class="col col-md-7">
               <div class="form-group">
                <label for="exampleInputEmail1">Select Stock</label>
                <select class="form-control select2 input-lg" style=" width: 100%;" id = 'stock'> 
                 <option></option>
                 <?php $stocks = get_all('stocks',$connection)?>
                 <?php foreach ($stocks as $stock): ?>
                  <option id = '<?=$stock['id']?>' price_per_ton = '<?=$stock['cost_per_ton']?>'>
                    <?= $stock['description']?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
          </div>

          <div class="col col-md-5">
            <div class="form-group">
              <label >Price Per Ton</label>
              <input type="number" id='price_per_ton' class = 'form-control input-lg'>
            </div>
          </div>

        </div>
        <!-- end stock -->
        <div class="form-group">
          <label for="exampleInputPassword1">Quantity</label>
          <input type="number" class="form-control input-lg" id="quantity_sold" placeholder="Quantity" required>
        </div>

        <div class="form-group">
          <label for="exampleInputPassword1">Quantity Per Ton</label>
          <input type="number" class="form-control input-lg" id="quantity_per_ton" placeholder="How Many Makes One Ton For This Stock" required>
        </div>


      </div>
      <!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-primary btn-block" id= 'add-stock'>
          Add Stock

          <span class = "glyphicon glyphicon-plus"></span>
        </button>
      </div>
    </form>
  </div>




</div>

</div>
</div>
</div>
<div class = 'col-md-4' >
  <div class="box box-solid" style="max-height:450px;margin-bottom:0px; " >
    <div class="box-header with-border bg-purple"> 

      <h4 class="box-title">Posted Stocks </h4>
      <span class= 'pull-right glyphicon glyphicon-trash' id = 'del_all_stocks'></span>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>

    </div> 

    <table id="layout-skins-list" class="table table-striped bring-up nth-2-center" style="margin-bottom: 0px">
      <thead>
        <tr>
          <th>Total</th>
          <th>Total Quantity</th>
        </tr>
      </thead>
      <tbody>

        <tr >
          <td style="font-size: 30px">
            <code class="animated" style="color:green" id = 'show_total_sale'></code>
          </td>
          <td style="font-size: 30px">
            <code class="animated" style="color:green" id = 'show_total_qty'></code>
          </td>
        </tr>

        <tr>
          <td colspan="2"><label>Amount Paid</label>
            <input  class = 'form-control input-lg' type="text" name="" style="width:100%" id = 'new_amount_paid'>
          </td>
        </tr>
      </tbody>
    </table>

    <div class = 'box-body' id = 'cart' style="margin-bottom:0px;overflow-y:scroll;overflow-x: hidden;max-height:162px;">

    </div>
    <!-- /.box-body --> 
    <button class = 'btn bg-purple btn-block input-lg proceed' id = 'proceed'>
      Print This Invoice &nbsp <span class = 'glyphicon glyphicon-print'></span>
    </button>

  </div>

  <!-- item supplied YES? NO? -->
  <div style="margin-top: 0px; border-top:none;" class ='box with-border' id='confirm__supply__status'>

   <!-- the wave -->
   <div class="sk-wave" style="display: none">
    <div class="sk-rect sk-rect1"></div>
    <div class="sk-rect sk-rect2"></div>
    <div class="sk-rect sk-rect3"></div>
    <div class="sk-rect sk-rect4"></div>
    <div class="sk-rect sk-rect5"></div>
  </div>
  <!-- emd wave -->

  <div style="padding: 15px">
    <p style="text-align: center;padding:0px">Has The Items Been Supplied to <span id = "customer_name">JUDE</span> ?</p>
    <h1 style="text-align: center;margin-top:0px" >
      <button  class = 'btn btn-success animated status-btn' id = "item_supplied" >
        YES <span class="glyphicon glyphicon-ok status-btn"></span>
      </button>

      <button class = 'btn btn-warning animated status-btn' id = "item_not_supplied">
        NO <span class="glyphicon glyphicon-remove"></span>
      </button>
    </h1>
  </div>
</div>
</div>
</div>

</div>
</div>

<!-- end content  -->
<script src="../js/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../js/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/app.min.js"></script>

<script type="text/javascript" src = '../js/native-toast.js'></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script> 
<!-- <script src="../js/fetch-data.js"></script>  -->
<script src="../plugins/select2/select2.min.js"></script>
<script type="text/javascript" src = '../js/sell.js'></script>
</body>
</html>

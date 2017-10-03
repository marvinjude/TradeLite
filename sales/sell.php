<?php
session_start();
$connection = include('../resources/conection.inc.php');
include_once '../functions/invoice_functions.php';
if(!isset($_SESSION['user'])){
  header("Location: ../index.php");
}

//unserialize data in user session
$user_data = unserialize($_SESSION['user']);

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

    
    <style>
    #sale-body{

    }



    .sale-head{
     padding: 10px;
     color:white;
     background-color: #3c8dbc;
   }
   .sale-head .sale-row{
    text-align: center;

  }

  .sale-bottom{
    padding : 15px;
    background-color: whitesmoke;
  }

  .hover-red:hover{
    color: red;
  }

  .fix-width{
    max-width: 1200px;
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
      <div class="content-wrapper ">
      <!--   <section class="content-header">
          <h1>
             New Sale
          </h1>
          <hr>         
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Post Expense</a></li>
            <li class="active">View Expense</li>
          </ol>
        </section>
      -->
      <div class = 'container'>
        <br>

        <div class = 'row'>
         <div class = 'col col-md-11'>
           <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Sales Information</h3>
            </div>
            <div class="box-body">
              <div class = 'row'>

               <div class = 'col-md-4 col-sm-4'>
                <div class="form-group">
                  <label>Customer</label>
                  <select class="form-control select2" style=" width: 100%;"
                  id = "customer" >
                  <option></option>
                  <?php $all_data = get_all('customers')?>
                  <?php foreach ($all_data as $row): ?>
                    <option>
                      <?= $row['id']. " - ".strtoupper($row['customer_name']) . " - ".$row['customer_phone']?>
                    </option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>

            <div class = 'col-md-4 col-sm-4 col-xs-4'>
              <label>invoice Number</label>
              <input class="form-control input-lg" type="number" name="invoice-number" 
              value = 
              <?php
              echo  genNewInvoiceNumber($mysqli);
              ?>
              >
            </div>

            <div class = 'col-md-4 col-sm-10 col-xs-12' style="">
              <label>Sale Date</label>
              <input class="form-control input-lg" type="date"  id = 'sale_date'
              >
            </div>

          </div>



        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>


  <!-- customer info  -->

  <!-- customer info end  -->
  <div classs = 'row'>
    <div class = 'col col-md-11'>

     <br>
     <div class="box box-primary">
      <div class="box-header with-border" >
        <h3 class="box-title ">Sales Form</h3>
      </div>



      <div class="box-body no-padding">

        <!-- head  -->
        <div class = 'container-fluid'>


          <div class="row sale-head ">
            <div class="col-xs-3  col-md-1 sale-row">
             S/No
           </div>
           <div class="col-xs-3  col-md-4 sale-row">
            STOCK 
          </div>
          <div class="col-xs-3 col-md-4 sale-row">
            QUANTITY 
          </div>
          <div class="col-xs-3 col-md-2 sale-row">
            SUBTOTAL
          </div>
        </div>


        <!-- close head -->




        <div  id = 'sale-body'>

        </div>

        <div class="row sale-head ">
          <div class="col-xs-3  col-md-1 sale-row">

          </div>
          <div class="col-xs-3  col-md-4 sale-row">

          </div>
          <div class="col-xs-3 col-md-4 sale-row">
            <b>TOTAL QUANTITY : 54</b>
          </div>
          <div class="col-xs-3 col-md-2 sale-row">
            <b>TOTAL : 290,000</b>
          </div>
        </div>



        <div class = 'row sale-bottom '> <!-- row for the submit button and print invoice -->
          <div class = 'col-md-6'>
            <button class = 'btn btn-success '>Save And Print Invoice &nbsp<i class ='glyphicon glyphicon-print'></i></button>
          </div>

          <div class = 'col-md-6 '>
            <button class = 'btn btn btn-info pull-right' id = 'save' >Save <i class ='glyphicon glyphicon-send'></i></button>
          </div>
        </div>   <!-- end row for button -->









      </div>


    </div>
  </div>



</div>



</div>
    <!-- <div class = 'row'> row for the submit button and print invoice
     <h1>hello</h1>
   </div>   <!-- end row for button --> 
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
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script> 

<!-- <script src="../js/fetch-data.js"></script>  -->
<script src="../plugins/select2/select2.min.js"></script>
<script type="text/javascript">

  $('document').ready(function(){
    $('.select2').select2();

    //$("input[type = 'date']").val(Date());
    var first_sale_input_row = " <div class = 'input-row box-body'><div class='row'><div class='col-xs-1 serial-count'><p class = 'count'></p> </div><div class='col-xs-5'><input type='text' class='form-control stock' placeholder='.col-xs-3'></div><div class='col-xs-3'><input type='text' class='form-control quantity ' placeholder='.col-xs-4'></div><div class='col-xs-2'><input type='text' class='form-control subtotal  trigger_next' placeholder='.col-xs-4'></div><button type=' button' style = 'padding:10px'  class='btn btn-success add pull-right '><i class = ' glyphicon glyphicon-plus'></i></button> </div></div>";

    var sale_input_row = " <div class = 'input-row box-body'><div class='row'><div class='col-xs-1 serial-count'><p class = 'count'></p> </div><div class='col-xs-5'><input type='text' class='form-control stock' placeholder='.col-xs-3'></div><div class='col-xs-3'><input type='text' class='form-control quantity ' placeholder='.col-xs-4'></div><div class='col-xs-2'><input type='text' class='form-control subtotal  trigger_next' placeholder='.col-xs-4'></div><button  type='button' style = 'padding:8px'  class='close close-row hover-red' >&times;</button> </div></div>";


    $('#sale-body').append(first_sale_input_row);


    $('.add').click(function(){
      // localStorage.setItem('count',$('#sale-body').find('.count').length); 
      $('#sale-body').append(sale_input_row);
      // alert(localStorage.getItem('count'));
      
      $('.close-row').on('click',function(event){
        event.preventDefault();
        $(this).parents('.input-row')
        .remove();
      });
    });



    $('#save').on('click', function(){
      //console.log($('.sale_input_row').serialize());
      // var  data = JSON.stringify({
        // var data =
        // "customer_id": $('#customer').val(),
        // "sale_date" :  $("#date").val.val(),
        // "incoice_numer": $('#invoice_number'),
        // "seller_id": <?php //echo $user_data['username']?>
      // });
      
      var o = [];
      $('.input_row').each(function(){

       var stock = $(this).find('.stock').val();
       var quantity = $(this).find('.quantity').val();
       var subtotal = $(this).find('.subtotal').val();

       item = {};

       item["stock"] = stock;
       item["quantity"] = quantity;
       item["subtotal"] = subtotal;


       o.push(item);

     });
      console.log (JSON.stringify(o));

      var data  = JSON.stringify({
        "customer_id": 11,
        "sale_date" : "2017-09-12",
        "invoice_number": 60002,
        "seller_id": 1,
        "sales":[
            {"stock_id": "1", "quantity": "10" ,"subtotal": "9087"},
            {"stock_id": "2" , "quantity": "10" , "subtotal": "789"},
            {"stock_id": "3" , "quantity": "10" ,"subtotal" :"67890"}
        ],
        "amount_paid" : "9000"
      });


      $.ajax({
        url: 'create_sale_ajax.php',
        type : 'POST',
        data: {'data': data},
        success : function(result){
          console.log(result);
        },
        async : true,
        beforeSend : function(){},
        error: function(xhr){}
      });



    });


  });







  ////////////////////////functions ///////////////////////























// $('#save').click(function(){
//  var stock;
//  var quantity;
//  var subtotal;
//  var row;

//  console.log($('.input-row'));
//  console.log($('.input-row').get(0));

//  for(row of $('.input-row')){
//   console.log(row);
//   stock = row.find('.stock').val();
//   quantity = row.find('.quantity').val();
//   subtotal = row.find('.subtotal').val();
//   console.log(stock,quantity,subtotal);
// }

// });

// });









</script>>
</body>
</html>

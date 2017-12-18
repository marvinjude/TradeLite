<?php session_start();

if (!isset($_SESSION['user'])){header("Location:../index.php");}
?>

<?php  include "sales.inc.php" ?>

  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Mukaz| Sales</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <!-- Ionicons -->

    <link rel="stylesheet" href="../css/native-toast.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="../css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">

    <link rel="stylesheet" href="../css/animate.min.css">
    <!-- Morris chart -->
    <!--  <link rel="stylesheet" href="../plugins/morris/morris.css"> -->

    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <!-- jvectormap -->

    <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <link rel="stylesheet" href="../css/ionicons.min.css">

    <!-- <script type="text/javascript" src = '../js/angular.min.js'></script> -->

    <style type="text/css">
    .edit{
     cursor: pointer;
     padding:10px;
   }
   td{
    text-transform: uppercase;
  }
  input,select{
    text-transform: uppercase;
  }

  h1{
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
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
        <!--Modal Add New Debtor-->

        <!-- start modal- modal for edit product/stock -->
        <div class="example-modal">
          <div class="modal modal-reduce-debt animated pulse" >
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Customer Record</h4>
                  </div>
                  <div class="modal-body">
                    <!-- modal body -->
                    <form role="form"  method="POST" action = "../sales/incr_amount_paid.php"?> 
                      <div class="box-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1"> Enter Amount Paid</label>
                          <input type="number" class="form-control" name ='amount' placeholder="Amount" >
                        </div>

                        <input type="number" id="new-amount" name ='sale' hidden>

                        <div class="modal-footer">
                          <input  type="submit" class="btn btn-primary" value = "Save changes" 
                          name = "update_customer" id = "modal_hide">
                        </div>

                        <input type="text" name="id" id = "id" hidden>

                      </div>
                    </form>

                  </div>

                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>

          </div>
          <!-- /.modal -->

          <section class="content-header">
            <h1>
              Sales
            </h1>       
            <ol class="breadcrumb">
              <li><a href="#"><i class="glyphicon glyphicon-search"></i> Home</a></li>
              <li><a href="#">Sales</a></li>
              <li class="active">Debtors</li>
            </ol>
          </section>

          <!-- the search area -->
          <div class = 'row' >
           <div class = "col-xs-10 col-md-4 pull-right" style = "padding-right:30px; padding-top:10px;padding-left:10px; padding-bottom:10px;">
            <form>
             <div class="input-group input-group-sm">
              <input type="text" class="form-control" id ='sale-invoice-num' placeholder = 'Enter Invoice Number To Delete' required>
              <span class="input-group-btn">
                <button type="button" class="btn btn-info btn-flat" id = "delete-sale-by-invoice">Delete!</button>
              </span>
            </div>
          </form>
        </div>
      </div>
      <!-- ends here -->


      <div class = "container-fluid">

        <div class = "row">
          <div>
            <div class = 'col col-md-3'>
             <div class="small-box bg-blue animated slideInLeft">
              <div class="inner">
                <h3 id = 's1'>
                 <?php  
                 echo number_format(getTodaySales($connection));
                 ?>
               </h3>

               <p>Today Sales</p>

               <div class="btn-group">
                <button type="button" class="btn btn-sm btn-success"
                today-sales-total = "<?php echo getTodaySales($connection)?>" id='v1'>Today</button>
                <button type="button" class="btn btn-sm btn-success" all-sales-total = "<?php echo getTotalSales($connection) ?>" id = 'v2'>Total</button>
              </div>
            </div>
            <div class="icon" style="margin-top: 10px">
              <i class="glyphicon glyphicon-euro"></i>
            </div>
          </div>
        </div>

        <div class = 'col col-md-3'>
         <div class="small-box bg-aqua animated slideInLeft">
          <div class="inner">
            <h3 id = 's2'>
             <?php  

             echo getSalesCount($connection);

             ?>
           </h3>
           <p>Sales Count</p>
           <div class="btn-group">
            <button type="button" class="btn btn-sm btn-success" sales-count-today = "<?php echo getSalesCountToday($connection)?>" id = 'v3'>Today</button>
            <button type="button" class="btn btn-sm btn-success"
            sales-count-all = "<?php echo getSalesCount($connection)?>" id = 'v4'>Total</button>
          </div>

        </div>
        <div class="icon">
          <button id = 'new-debtor' class = 'btn btn-warning' style="margin-bottom: 50px">
            Sell Now  <span class = "glyphicon glyphicon-send"></span>
          </button>
        </div>
      </div>
    </div>

  </div>


  <!-- data table col -->
  <div class = 'col col-md-12'>
    <div class="box with-border box-primary">
      <div class="box-header  ">
        <h3 class="box-title">Customers</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table id="example2" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>S/N</th>
              <th>Customer Name</th>
              <th>Phone</th>
              <th>Invoice Number</th>
              <th>Amount Paid</th>
              <th>Total</th>
              <th>Supplied</th>
              <th>Date</th>
              <!-- button -->
              <th></th>
              <!-- button -->
            </tr>
          </thead>

          <tbody>
            <?php $i = 0;?>
            <?php while($sale = mysqli_fetch_assoc($sales)){ ?> 
            <tr>
              <td><?php echo  ++$i ?></td>
              <td><?php echo  $sale['customer_name'] ?></td>
              <td><?php echo  $sale['customer_phone'] ?></td>
              <td>
                <a href = '../sales/invoice.php?id=<?php echo  $sale['invoice'] ?>'>
                  <?php echo  $sale['invoice'] ?>
                </a>
              </td>

              <td><?php echo  $sale['amount_paid'] ?></td>
              <td><?php echo $sale['total'] ?></td>
              <td>
                <?php

                   if($sale['supply_status'] == 1){
                      echo 'YES';
                   }else{
                       echo 'NO';
                   }
                ?>
              </td>
              <td><?php echo $sale['sale_date'] ?></td>
              <td>
                <button class = 'btn btn-danger btn-sm paid-all' sale_id = "<?= $sale['id']?>" invoice-number = <?= $sale['invoice']?> > 
                 <span class = 'glyphicon glyphicon-remove'></span>
               </button>
             </td>
             <?php } ?>                                                 
           </tr>
         </tbody>
       </table>
     </div>
     <!-- /.box-body -->
   </div>



 </div>

 <!-- datatable col end  -->
</div>



<!-- /.box-body -->
</div>
<!-- /.box -->
</div>
</div>

<script src="../js/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../js/bootstrap.min.js"></script>

<script src="../plugins/datatables/jquery.dataTables.min.js"></script>

<script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../js/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/app.min.js"></script>

<script type="text/javascript" src = '../js/native-toast.js'></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script> 
<script type="text/javascript">

  $('document').ready(function(){

    $("#v1").on("click", function(){
      let number = $(this).attr('today-sales-total');
      $("#s1").text(number);
    });

    $("#v2").on("click", function(){
      let number = $(this).attr('all-sales-total');
      $("#s1").text(number);
    });

    $("#v3").on("click", function(){
      let number = $(this).attr('sales-count-today');
      $("#s2").text(number);
    });

    $("#v4").on("click", function(){
      let number = $(this).attr('sales-count-all');
      $("#s2").text(number);
    });



    $("#delete-sale-by-invoice").on('click', function(){
     var invoice = $('#sale-invoice-num').val();
     if(confirm('Are You Sure You Want To Delete Sale With Invoice Number ' + invoice +
       ' This Operation Is Irreversabele')){

      $.post("../sales/sales.inc.php",
      {
        iid: invoice
      },
      function(data,status){
      data = JSON.parse(data);
       if(data.status == 1){
        showToast('success', "Successfully Delete Sale With Invoice Number " + invoice);
        setTimeout(()=>{location.reload()},3000);
      }else{
        showToast('error', "Unable To Delete Sale With Invoice Number " + invoice);
      }
    });
  }});
   

  $('.enter_amt_paid').click(function(){
    $('.modal-reduce-debt').modal();
    var sale_id = $(this).attr('sale_id');
    $('#new-amount').val(sale_id);
  });



  $('.paid-all').click(function(){
    var sid = $(this).attr('sale_id');
    var invoice = $(this).attr('invoice-number');

    var should_delete_sale = confirm(`Are You Sure You Want To Delete This Sales With Invoice Number ${invoice} Remember This Action Is Irreversabele`);
    if(should_delete_sale){
      console.log('Deleting...');
      window.location = '../sales/sales.inc.php?sid=' + sid;
    }
  });


  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "fnRender":function(){
       var sReturn = obj.aData[obj.DataColumn];
       var returnButton = "<input class  type = 'submit'approveButton' value = 'click'> ";
       return returnButton;

     },
     "paging": true,
     "lengthChange": true,
     "searching": true,
     "ordering": true,
     "info": true,
     "autoWidth": true
   });
  });

     
   function showToast(type, message){
    var useEdge = true;
    var useDebug = false;
    nativeToast({ message: message, square: true, edge: useEdge, debug: useDebug,  type : type });
  }

});
  </script>

</script>
</body>
</html>






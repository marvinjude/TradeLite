<?php session_start();
$connection = include('../resources/conection.inc.php');
include '../functions/debtors_functions.php';


if (!isset($_SESSION['user'])){
  header("Location : ../index.php");
}
$deptors_data = getAllDebtors($connection);
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Mukaz| Deptors</title>
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

    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
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


        <!-- start modal- modal for edit product/stock -->
        <div class="example-modal">
          <div class="modal animated pulse" >
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


                    <!-- modal body end -->


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
              Debtors
            </h1>       
            <ol class="breadcrumb">
              <li><a href="#"><i class="glyphicon glyphicon-search"></i> Home</a></li>
              <li><a href="#">Sales</a></li>
              <li class="active">Debtors</li>
            </ol>
          </section>
          <hr>
          <div class = "container-fluid">

            <div class = "row">







              <div class = 'col col-md-3'>
               <div class="small-box bg-maroon animated slideInLeft">
                <div class="inner">
                  <h3>

                   <?php  
                   echo number_format(getTotalDebt($connection));
                   ?>

                 </h3>

                 <p>Total Debt</p>
               </div>
               <div class="icon">
                <i class="glyphicon glyphicon-euro"></i>
              </div>
              <a href="#" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
            </div>

          </div>

          <div class = 'col col-md-3'>
           <div class="small-box bg-maroon animated slideInLeft">
            <div class="inner">
              <h3>

               <?php  

               echo getNumDebtors($connection);

               ?>

             </h3>

             <p>Number Of Debtors</p>
           </div>
           <div class="icon">
            <i class="glyphicon glyphicon-user"></i>
          </div>
          <a href="#" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
        </div>

      </div>

      <!-- data table col -->
      <div class = 'col col-md-12'>
        <div class="box with-border box-danger">
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
                  <th>Amount Owed</th>
                  <th>Date Owed</th>
                  <th></th>
                </tr>
              </thead>

              <tbody>
                <?php while($deptor = mysqli_fetch_assoc($deptors_data)){ ?> 
                <tr>
                  <td>1</td>
                  <td><?php echo  $deptor['customer_name'] ?></td>
                  <td><?php echo  $deptor['customer_phone'] ?></td>
                  <td>
                    <a href = '../sales/invoice.php?id=<?php echo  $deptor['invoice_number'] ?>'>
                      <?php echo  $deptor['invoice_number'] ?>
                    </a>
                  </td>

                  <td><?php echo  $deptor['total-amount_paid'] ?></td>
                  <td><?php echo $deptor['sale_date'] ?></td>
                  <td>
                    <div class="btn-group">
                      <button class = 'btn btn-success paid-all' sale_id = '<?php echo $deptor['id'] ?>'
                       amount-owed = '<?php echo $deptor['total-amount_paid'] ?>'
                       cus_name = '<?php echo $deptor['customer_name'] ?>' >Paid 
                       <span class = 'glyphicon glyphicon-ok'></span>
                     </button>
                     <button class = 'btn bg-orange enter_amt_paid' sale_id = '<?php echo $deptor['id'] ?>'>Add
                       <span class = 'glyphicon glyphicon-plus'></span>
                     </button>
                   </div>
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
   function showToast(type, message){
      var useEdge = true;
      var useDebug = false;

      nativeToast({
        message: message,
        square: true,
        edge: useEdge,
        debug: useDebug,
        type : type 
      });
    }

    
    $('.enter_amt_paid').click(function(){
          $('.modal').modal();
          var sale_id = $(this).attr('sale_id');
          $('#new-amount').val(sale_id);
    });



    $('.paid-all').click(function(){
      var sale_id = $(this).attr('sale_id');
      var customer_name = $(this).attr('cus_name');
      var amt = $(this).attr('amount-owed');

      var should_mark_payment_complete = confirm('Are You Sure That ' + customer_name + " Has Paid The Sum Of " + amt + ' Naira  ? Remember This Action Is Irreversabele');
      if(should_mark_payment_complete){
        window.location = '../sales/completepayment.php?sale=' + sale_id;
      }
    });


    $('.edit').on('click', function(event){
      var button =  event.target;
      var customer = button.getAttribute('customer_data');
      var customer = JSON.parse(customer);
      console.log(customer);

      $('#customer_name').val(customer.customer_name);
      $('#customer_datecreated').val(customer.date_created);
      $('#customer_address').val(customer.address);
      $('#customer_phone').val(customer.customer_phone);
      $('#id').val(customer.id);

      $('.modal').modal();
    });



    $('#cost_per_ton').on('click',function(){
      $('.modal').hide();
    });

    $('#editstock').on('click',function(){
      $('.modal').modal();
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


  });

</script>

</script>
</body>
</html>



































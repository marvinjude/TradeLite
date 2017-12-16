<?php session_start();
    if (!isset($_SESSION['user'])){
      header("Location : ../index.php");
    }

    $connection = include('../resources/conection.inc.php');
    include '../functions/debtors_functions.php';

    $deptors_data = getAllDebtors($connection);

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

    <script type="text/javascript" src = '../js/angular.min.js'></script>

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
        <div class="example-modal">
          <div class="modal modal-add-debtor animated pulse" >
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add New Debtor</h4>
                  </div>
                  <div class="modal-body">
                    <!-- modal body -->
                    <form ng-app= "Debt" ng-controller = 'createDebtor' name = 'debtForm'>
                      <div class="box-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1"> Customer  or 
                            <small><a href = '../customer/new.php'>create new customer</a></small>
                          </label>

                      <select id = 'customers' class="form-control select2 "
                          style=" width: 100%;" ng-model = 'customer' required> 
                          <!-- get all customers and render to html -->
                          <?php $customers = get_all('customers',$connection)?>
                          <option></option>
                          <?php foreach ($customers as $customer): ?>
                             <option data-customer-id = '<?=$customer['id']?>' >
                              <?= $customer['customer_name'] ?>
                              (<?=$customer['customer_phone']?>)
                          </option>
                        <?php endforeach ?>
                      </select>
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1"> Amount</label>
                          <input type="number" class="form-control" id ='debt-amount' placeholder="Amount" required
                          ng-model = 'amount' ng-min = '1'>
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1"> Date</label>
                          <input type="date" class="form-control" id ='debt-date' placeholder="Amount" 
                          ng-model = 'date' required>
                        </div>

                        <div class="modal-footer">
                          <input  type="submit" class="btn btn-primary" value = "Save Debtor" 
                          name = "update_customer" id = "save_debtor" data-dismiss="modal" aria-label="Close" ng-disabled = "debtForm.$invalid ">
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
               <div class="icon" style="margin-top: 10px">
                <i class="glyphicon glyphicon-euro"></i>
              </div>
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
             <button id = 'new-debtor' class = 'btn btn-warning' style="margin-bottom: 50px">New Debtor</button>
           </div>
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
                <?php $i = 0;?>
                <?php while($deptor = mysqli_fetch_assoc($deptors_data)){ ?> 
                <tr>
                  <td><?php echo  ++$i ?></td>
                  <td><?php echo  $deptor['customer_name'] ?></td>
                  <td><?php echo  $deptor['customer_phone'] ?></td>
                  <td>
                    <a href = '../sales/invoice.php?id=<?php echo  $deptor['invoice_number'] ?>'>
                      <?php echo  $deptor['invoice'] ?>
                    </a>
                  </td>

                  <td><?php echo  $deptor['amount'] ?></td>
                  <td><?php echo $deptor['debt_date'] ?></td>
                  <td>
                    <div class="btn-group">
                      <button class = 'btn btn-success paid-all' debt_id = '<?php echo $deptor['debt_id'] ?>'
                       amount-owed = '<?php echo $deptor['amount'] ?>'
                       cus_name = '<?php echo $deptor['customer_name'] ?>' >Paid 
                       <span class = 'glyphicon glyphicon-ok'></span>
                     </button>
                     <button class = 'btn bg-orange enter_amt_paid' sale_id = '<?php echo $deptor['debt_id'] ?>'>Add
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

//angular code


angular.module('Debt', [])
   .controller("createDebtor", function($scope){
      
   }); 


  $('document').ready(function(){

   function showToast(type, message){
      var useEdge = true;
      var useDebug = false;

      nativeToast({
        message: message,
        square: true,
        edge: useEdge,
        debug: useDebug,
        type : type,
      });
    }

    
    $('.enter_amt_paid').click(function(){
          $('.modal-reduce-debt').modal();
          var sale_id = $(this).attr('sale_id');
          $('#new-amount').val(sale_id);
    });



    $('.paid-all').click(function(){
      var debt_id = $(this).attr('debt_id');
      var customer_name = $(this).attr('cus_name');
      var amt = $(this).attr('amount-owed');

      var should_mark_payment_complete = confirm('Are You Sure That ' + customer_name + " Has Paid The Sum Of " + amt + ' Naira  ? Remember This Action Is Irreversabele');
      if(should_mark_payment_complete){
        console.log('payment marked completed');
        console.log(debt_id);
        window.location = '../sales/completepayment.php?debt=' + debt_id;
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

     // Add debtor module
    $(function(){
        $("#new-debtor").on('click', function(){
           $('.modal-add-debtor').modal();
        });  

        $('#save_debtor').on('click', function(e){
            let selectedIndex = document.getElementById('customers').selectedIndex;
            let customer_id  =  document.getElementById('customers')
                   .options[selectedIndex].getAttribute('data-customer-id');
            
            let amount_owed = $('#debt-amount').val();
            let date = $('#debt-date').val();

            $.post("newdebtor.php",
             {
               customer : customer_id,
               date: date,
               amount_owed: amount_owed
             },

             function(data,status){
                 if(status == 'success'){
                    showToast('success', 'Debtor Successfully Added');
                    setTimeout(()=>{location.reload()},2000);
                 }
             });
        }); 
    });


  });

</script>

</script>
</body>
</html>






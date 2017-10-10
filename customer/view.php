
<?php
$connection = include('../resources/conection.inc.php');


if (isset($_POST['update_customer'])){
  $id = trim($_POST['id']);
  $name   = $_POST['name'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  update_customer($connection,$name,$phone,$address,$id);
}

function Dformat($date_str){
 return date("d/m/Y",strtotime($date_str));
}

function update_customer($connection,$name,$phone,$address, $customer_id){
  $query = "UPDATE  customers SET customer_name = '$name', customer_phone = '$phone' , address = '$address'
  WHERE id = '$customer_id' ";
  if (mysqli_query($connection,$query)){
    return true;
  }else{
    trigger_error("error: " . mysqli_error($connection));
    return false;
  }
}


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

                    <form role="form"  method="POST" action = <?php echo $_SERVER['PHP_SELF']?> >
                      <div class="box-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Name</label>
                          <input type="text" class="form-control" id ="customer_name" name="name"  
                          >
                        </div>

                        <div class="form-group">
                          <label for="exampleInputPassword1">Phone</label>
                          <input type="number" class="form-control" id = "customer_phone" name='phone'>
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Address</label>
                          <textarea type="text" class="form-control" id="customer_address" name = 'address'  ></textarea>
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1"> Registration Date</label>
                          <input type="date" class="form-control" id="customer_datecreated"  disabled>
                        </div>

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
              View Customers
            </h1>       
            <ol class="breadcrumb">
              <li><a href="#"><i class="glyphicon glyphicon-search"></i> Home</a></li>
              <li><a href="#">Customer</a></li>
              <li class="active">View</li>
            </ol>
          </section>
          <hr>
          <div class = "container-fluid">

            <div class = "row">







              <div class = 'col col-md-3'>
               <div class="small-box bg-aqua animated slideInLeft">
                <div class="inner">
                  <h3>

                   <?php  

                   $tabledata = get_all('customers');
                   echo count($tabledata);

                   ?>

                 </h3>

                 <p>Total Customers</p>
               </div>
               <div class="icon">
                <i class="glyphicon glyphicon-th"></i>
              </div>
              <a href="#" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
            </div>

          </div>

          <!-- data table col -->
          <div class = 'col col-md-12'>
            <div class="box with-border box-aqua">
              <div class="box-header bg-aqua ">
                <h3 class="box-title">Customers</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Customer Name</th>
                      <th>Phone Number</th>
                      <th>Registration Date</th>
                      <th>Address</th>
                      <th>Edit</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php  $datatable = get_all('customers');  ?>
                    <?php foreach ($datatable  as $row ): ?>
                      <tr>
                        <td><?= $row['id']?></td>
                        <td><?=$row['customer_name']?></td>
                        <td><?=$row['customer_phone']?></td>
                        <td> <?=Dformat($row['date_created'])?></td>
                        <td><?=$row['address']?></td>
                        <td ><span class=" btn btn-sm bg-green glyphicon glyphicon-pencil edit" id = "test" customer_data = <?= "'". json_encode($row) ."'" ?>  ></span></td>
                      </tr>

                    <?php endforeach ?>


                  </tbody>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Customer Name</th>
                      <th>Phone Number</th>
                      <th>Registration Date</th>
                      <th>Address</th>
                      <th>Edit</th>
                    </tr>
                  </tfoot>
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
  <!-- AdminLTE for demo purposes -->
  <script src="../dist/js/demo.js"></script> 
  <script type="text/javascript">
    $('document').ready(function(){



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



































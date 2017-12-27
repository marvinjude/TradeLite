<?php session_start();

$connection = include('../resources/conection.inc.php');

if(!isset($_SESSION['user'])){
  header("Location: ../");
}

if(isset($_GET['submit'])){
  $data = get_all('bank_deposits',$_GET['start'],$_GET['end']);
}else{
   $data = get_all('bank_deposits');
}

function get_all($table, $start_date = '', $end_date = ''){
  global $connection;
  $all_data = array();

  if($start_date == '' || $end_date == ''){
      $query = "SELECT * FROM $table";
  }else{
      $query = "SELECT * FROM $table WHERE date_deposited BETWEEN '$start_date' AND '$end_date'";
  }

 
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
  <title>MUKAZ | View Bank Deposit</title>
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
tr{
  text-transform: uppercase
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
        <div class="container">
          <div class="row" style="margin-top:10px">
            <div class="col-md-11">
              <div class="box">
              <div class="box-body">
                <form method = 'GET'>
                  <div class="col-xs-4">
                    <label>Start Date</label>
                    <input type="date" class="form-control" name = "start">
                  </div>
                  <div class="col-xs-4">
                    <label>End Date</label>
                    <input type="date" class="form-control" name = "end">
                  </div>
                  <div class="col-xs-2" style="padding-top:23px">
                    <input type="submit" class="btn btn-primary" value = 'Go' name= 'submit'>
                  </div>
                </form>
              </div>
            </div>
            </div>
          </div>

        <!-- data table col -->
        <div class="row">
          <div class = 'col col-md-11' style="margin-top: 10px">
            <div class="box with-border box-primary">
              <div class="box-header  ">
                <h3 class="box-title">View Bank Deposits</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="example" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th><b style="color: red">S/N</b></th>
                      <th>Bank-Name</th>
                      <th>Amount-Deposited</th>
                      <th>Date-Deposited</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php foreach ($data as $row ): ?>
                      <tr>
                        <td><?= $row['id']?></td>
                        <td><?=$row['bank_name']?></td>
                        <td><?=$row['amount_deposited']?></td>
                        <td><?=date('d/m/Y',strtotime($row['date_deposited']))?></td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
              <!-- /.box-body -->
            </div>
          </div>
        </div>
        <!-- datatable col end  -->
      </div>
      <!-- /.box-body -->
    </div>
  </div>


    <script src="../js/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../js/bootstrap.min.js"></script>

    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>

    <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../js/fastclick.min.js"></script>

    <script src="../js/daterangepicker/moment.min.js"></script>

    <script src="../plugins/daterangepicker/daterangepicker.min.js"></script>

    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script> 

    <script type="text/javascript">
      $('document').ready(function(){
       $(function () {
        $('#example').DataTable({
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

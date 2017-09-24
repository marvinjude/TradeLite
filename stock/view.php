<?php
$connection = include('../resources/conection.inc.php');

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
          <div class="modal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Product</h4>
                  </div>
                  <div class="modal-body">

                    <!-- modal body -->

                    <form role="form">
                      <div class="box-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Name/Description</label>
                          <input type="text" class="form-control" id="exampleInputEmail1" disabled="disabled" >
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Type</label>
                          <input type="email" class="form-control" id="exampleInputEmail1" disabled="disabled" >
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1">Price Per Ton</label>
                          <input type="text" class="form-control" id="cost_per_ton" autofocus="true" >
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Quantity In Store</label>
                          <input type="email" class="form-control" id="exampleInputEmail1" disabled="disabled" >
                        </div>

                      </div>
                    </form>


                    <!-- modal body end -->


                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
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
              View Stocks
            </h1>
            <hr>         
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
              <li><a href="#">Stock</a></li>
              <li class="active">view</li>
            </ol>
          </section>
          <hr>
          <div class = "container-fluid">
            <div class = "row">



              <div class = 'col col-md-3'>
               <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>

                   <?php  

                   $tabledata = get_all('stocks');
                   echo count($tabledata);

                   ?>

                 </h3>

                 <p>Total Stock</p>
               </div>
               <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
            </div>

          </div>



          <div class = "col col-md-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">All Stocks</h3>
              </div>

              
              <!-- /.box-header -->
              <div class="box-body no-padding">
                <table class="table table-striped">


                  <tr>
                    <th >#</th>
                    <th>Name/Description</th>
                    <th>Quantity In Store</th>
                    <th >Price Per Ton</th>
                    <th>Last Receive Date</th>
                    <th >Date Created</th>
                    <th >_</th>
                  </tr>


                  <?php foreach ($tabledata as $row): ?>

                   <tr>
                    <td><?= $row['id'] ?></td>

                    <td><?= $row['description'] ?></td>

                    <td>  <?= $row['quantity_in_store'] ?> </td>

                    <td> <?= $row['cost_per_ton'] ?></td>

                    <td> <?= $row['last_receive_date'] ?></td>

                    <td> <?= $row['date_created'] ?></td>

                    <td>
                      <span class="badge bg-green edit" id = "test" stock_data = <?= "'". json_encode($row) ."'" ?>  >Change Price Per Ton</span>
                    </td>

                  </tr>


                <?php endforeach ?>



              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
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
     
     alert($('.test').stock_data);



    $('.edit').on('click', function(event){
        $('.modal').modal();
        
      //console.log($(source).parentsUntil("tr"))
    })

 

     $('#deletestock').on('click',function(){
      $('.modal').modal();
    });

     $('#editstock').on('click',function(){
      $('.modal').modal();
    });

   });

 </script>
</body>
</html>

          <?php session_start();
          $connection = include('../resources/conection.inc.php');
          $data = array();




          if(isset($_POST['generate_data'])) {
           $f_date = $_POST['f_date'];
           $s_date = $_POST['s_date'];

           $query = "SELECT * FROM expenses WHERE expense_date BETWEEN '$f_date' AND '$s_date'";



        if($result = mysqli_query($connection, $query)){


             $numrows = $mysqli_num_rows($result);
             if($numrows  > 0){
               for($i = 0; $i< mysqli_num_rows($result); $i++){
                array_push($data, mysqli_fetch_assoc($result));
              }
              else{

               $_SESSION['no_expense_for_dates_selected'];
             }



           }else{
             echo mysqli_error($connection,$query);
             $_SESSION['error_fetching_data'] = 'error';
           }

         }else{

          $data = get_all('expenses');
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

                <!-- /.modal -->



                <section class="content-header">
                  <h1>
                    View Expenses
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

                    <div class = 'col col-md-12 col-xs-12'>

                     <form  method="POST" action = <?php echo $_SERVER['PHP_SELF']?> >
                      <div class="box box-danger">
                        <div class="box-header with-border">
                          <h3 class="box-title">Select The Start And  End Date </h3>
                        </div>
                        <div class="box-body">
                          <div class="row">

                            <div class="col-xs-10 col-md-4">
                              <div class="input-group">
                                <span class="input-group-addon" >
                                 <i class = "glyphicon glyphicon-calendar"></i>
                               </span>
                               <input type="date" class="form-control" name = 'f_date' required>
                             </div>
                           </div>

                           <div class="col-xs-10 col-md-4">
                            <div class="input-group">
                             <span class="input-group-addon" >
                               <i class = "glyphicon glyphicon-calendar"></i>
                             </span>
                             <input type="date" class="form-control"  name = 's_date' required>
                           </div>
                         </div>

                         <div class="col-xs-4">
                          <input type="submit" value = "Generate" name= "generate_data" class=" btn btn-block btn " style = "background-color: #3c8dbc; color:white"  placeholder=".col-xs-5">
                        </div>
                      </div>
                    </div>
                    <!-- /.box-body -->
                  </div>
                </form>

              </div>


              <!-- data table col -->
              <div class = 'col col-md-12'>
                <div class="box box-danger with-border ">
                  <div class="box-header">
                    <h3 class="box-title">Customers</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <table id="example" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Description</th>
                          <th>Amount</th>
                          <th>Date</th>
                        </tr>
                      </thead>

                      <tbody>


                        <?php foreach ($data as $row ): ?>
                          <tr>
                            <td><?= $row['id']?></td>
                            <td><?=$row['expense_description']?></td>
                            <td><?=$row['expense_amount']?></td>
                            <td> <?=$row['expense_date']?></td>
                          </tr>

                        <?php endforeach ?>




                      </tbody>
                      <tfoot>

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

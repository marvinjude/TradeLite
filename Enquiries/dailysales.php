<?php

session_start();
$connection = include('../resources/conection.inc.php');
include_once('../functions/invoice_functions.php');
include_once('ctrl-dailysales.php');

if (isset($_POST['generate_data'])){
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
}else{
  $start_date = date ('Y/m/d',strtotime('tomorrow')); //remove this b4 pushing
 $end_date =   date ('Y/m/d',strtotime('tomorrow')); // remove this b4 pushing

  // $start_date = date ('d/m/Y') //use this
  // $end_date =   date ('d/m/Y') //use this 
}

?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Daily Sales</title>
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

  <link rel="stylesheet" href="../css/animate.min.css">
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

</head>
<style type="text/css">

table{
  background-color: white;
  /*border: 2px solid grey;*/
}
/*stop all text from wrapping*/
th,td{
 white-space: nowrap;
 text-transform: uppercase;
}

.point{
  cursor: pointer;
}

.inner-table{
  padding:0px;  
}


.inner-table table{
  width: 100%;
  padding:0px;
  height:100%;
}

.inner-table td{
  padding:5px;
}

.center-div{
  margin-top:10%;

}

.center-text{
  text-align: center;
}
.active-color{
  background-color: #3c8dbc;
  color:white;
}
.active-color:hover{
  background-color: #3c8dbc;
  color:white;
}
.no-padding{
  padding: 0px;
}

.rotated-90{
  transform: rotate(270deg);
  /*position: absolute;*/
  margin-top: 40px;
  font-weight: bold;
}
.padded{
  padding:5px;
}


</style>
<body>

  <body class="hold-transition skin-blue sidebar-mini">



    <!-- modal -->
    <div class="example-modal" >
      <div class="modal  animated slideInLeft" id = "stock_analysis_graph">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
                <h3 class="box-title">Sales From 
                  <strong> <?php echo date('d-m-Y',strtotime($start_date)) ?>
                  </strong> to
                  <strong>
                    <?php echo date('d-m-Y',strtotime($end_date)) ?>
                  </strong>(Analysis) 
                </h3>
              </div>
              <div class="modal-body">


                <!-- sale graph > -->
                <div class="box box-success">
                  <div class="box-body">
                    <div class="chart">
                      <canvas id="barChart" style="height: 300px; width: 451px;" height="416" width="902"></canvas>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- sale graph> -->


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline">Save changes</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      </div> 
      <!-- /.modal -->







      <!-- modal2 -->
      <div class="example-modal" >
        <div class="modal  animated slideInLeft stock-qty-sold" id = "modal_stock-qty-sold" >
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                  <h4 class="modal-title">Stock Sales From
                    <?php echo date("d/m/Y",strtotime($start_date)) . " - " . 
                    date("d/m/Y",strtotime($end_date)) ?></h4>
                  </div>
                  <div class="modal-body">


                    <!-- sale graph > -->
                    <div class="box box-success">

                      <div class="box-body">
                        <?php $stock_sale_data = getStockDescAndQtysold($connection,$start_date,$end_date,$type = 3);?>

                        <?php if (! empty($stock_sale_data)): ?>
                          <table id="layout-skins-list" class="table  table-bordered bring-up nth-2-center">
                            <thead>
                              <tr>
                                <th>Stock</th>
                                <th>Quantity Sold</th>
                              </tr>
                            </thead>
                            <tbody>
                             <!-- generates the stocks and quantity sold for those supplied days -->
                             <?php foreach ($stock_sale_data as  $row): ?>
                              <tr>
                                <td><?= $row ['description'] ?></td>
                                <td><?= $row ['SUM'] ?></td>
                              </tr>
                            <?php endforeach ?>

                          <?php else: ?>
                            <?= 
                            "<div class='alert alert-warning alert-dismissible'>
                            <h5><i class='glyphicon glyphicon-info-sign'></i> Alert! - There are not Data for the specified dates</h5>
                            .<br>
                            <h3 class = 'center-text'><span style = 'font-size:60px' class='glyphicon glyphicon-trash'><span></h3>
                            </div>"
                            ?>

                          <?php endif ?>









                        </tbody>
                      </table>




                      <!-- /.box-body -->
                    </div>
                    <!-- sale graph> -->
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline">Save changes</button>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
          </div> 
          <!--/ modal 2 -->


          <div class="wrapper">
            <!-- header  -->
            <?php  include('../resources/templates/header.php') ; ?>
            <!-- end header   -->


            <!-- Left side column. contains the logo and sidebar -->
            <?php  include('../resources/templates/mainsidebar.php') ; ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" >

              <div class="container-fluid" style="padding:20px">
               <div class = "row">
                <div class = 'col col-md-12'>


                  <form action = '<?php echo  $_SERVER['PHP_SELF']?>' method = "POST" >
                    <div class="box box-primary">
                      <div class="box-header with-border ">
                        <h3 class="box-title">Select The Start And  End Date </h3>
                        <span class = 'close'>&times</span>
                      </div>
                      <div class="box-body">
                        <div class="row">

                          <div class="col-xs-12 col-md-4">
                            <div class="input-group">
                              <span class="input-group-addon">
                               <i class="glyphicon glyphicon-calendar"></i>
                             </span>
                             <input type="date" class="form-control" name="start_date" value= '<?= date('Y-m-d',strtotime('today'))?>' required>
                           </div>
                         </div>

                         <!-- center arrow  -->
                         <div class="col-xs-12 col-md-1 center-text">
                          <span class = "glyphicon glyphicon-arrow-right"></span>
                        </div>
                        <!-- end center arrow  -->

                        <div class="col-xs-12 col-md-4">
                          <div class="input-group">
                           <span class="input-group-addon">
                             <i class="glyphicon glyphicon-calendar"></i>
                           </span>

                           <input type="date" class="form-control" name="end_date" value= '<?= date('Y-m-d',strtotime('today'))?>' required> 
                         </div>
                       </div>

                       <div class="col-xs-12 col-md-2 col-xs-12 col-sm-12">
                        <input type="submit" value="Generate" name="generate_data" class=" btn btn-block btn " style="background-color: #3c8dbc; color:white">
                      </div>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>

              </form>
            </div>
          </div>

          <div class = 'row'>
            <div class = 'col-md-12'>
             <div class="box box-primary">
              <div class="box-header with-border ">
                <h3 class="box-title">Sales From 
                  <strong> <?php echo date('d-m-Y',strtotime($start_date))?>
                  </strong> to
                  <strong>
                    <?php echo date('d-m-Y',strtotime($end_date)) ?>
                  </strong>(Analysis) 
                </h3>
                <span class = 'close'>&times</span>
              </div>
              <div class="box-body">
                <div class = 'table-responsive'>

                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Total Sales </th>
                        <th>Customer's Deposits </th>
                        <th>Balance BF </th>
                        <th>Expense</th> 
                        <th>Bank Deposit</th>
                        <th style = 'color:blue; font-weight: bold'>Cash @ Hand</th>
                        <th>Start Date</th> 
                        <th>End Date</th>
                      </tr>
                    </thead>

                    <tbody>
                      <tr>
                        <?php $raw_data = getRawData($connection,$start_date,$end_date);  ?>

                        <td><?= $raw_data['total_sales']?></td>
                        <td><?= $raw_data['customer_deposit']?></td>
                        <td><?= $raw_data['bbf']?></td>
                        <td><?= $raw_data['expenses'] ?></td>
                        <td><?= $raw_data['bank_deposits']?></td>
                        <td><?= getCashAtHand($raw_data)?></td>
                        <td><?= date('d-m-Y',strtotime($start_date)) ?></td>
                        <td><?= date('d-m-Y',strtotime($end_date)) ?></td>

                      </tr>
                    </tbody>

                  </table>

                </div>
                <button id = 'show-stock-graph' class = ' btn bg-navy pull-right'>
                  Sales Analysis <span class = 'glyphicon glyphicon-stats'></span>
                </button>

                <button class = 'btn bg-orange' id = 'show-stock-sales'>
                  View Stock sales
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- <end of sale analysis col -->



         <!-- end of date input col -->





         <!-- the sales table"s row  -->
         <div class="row">
          <div class="col-md-12 saleview">
            <!-- <section class="content"> -->
             <div class="box box-primary">
              <div class="box-header with-border ">
                <h3 class="box-title">Sales From 
                  <strong> <?php echo date('d-m-Y',strtotime($start_date)) ?>
                  </strong> to
                  <strong>

                    <?php echo date('d-m-Y',strtotime($end_date)) ?>
                  </strong>(Analysis) 
                </h3><span class=" gofullscreen pull-right point glyphicon glyphicon-fullscreen"></span>

              </div>
              <div class="box-body">
                <div class = 'table-responsive'>
                  <table class="table table-striped table-bordered bring-up nth-2-center" style="background-color: white; 
                  ">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>invoice Num</th>
                      <th>Stock Description</th>
                      <th>QTY</th>
                      <th>Ton Price</th>
                      <th>Selling Price</th> 
                      <!-- total reps subtotal for each subsale -->
                      <th> Total</th>
                      <th >Expense Description</th>
                      <th>Expense Amount</th>

                      <th>Bank</th>
                      <th>Amount Deposited</th>


                      <th>Customer's Name</th>

                      <th>Amount Deposited</th>
                      <th>Balance B/F</th>

                    </tr>



                  </thead>
                  <!-- ["sale_date"]=> string(10) "2017-09-12" ["customer_name"]=> string(11) "James Bower" ["invoice_number"]=> string(5) "60003" ["description"]=> string(4) "20mm" ["cost_per_ton"]=> string(5) "67890" ["quantity"]=> string(2) "10" ["selling_price"]=> string(1) "0" ["subtotal"]=> string(4) "9087"  -->

                  <tbody>
                    <!-- 1. normal sales table -->
                    <?php $left_sales = getSalesDataLeft($connection,$start_date, $end_date)?>
                    <?php foreach ($left_sales as $row): ?>
                      <tr>
                        <td><?= Dformat($row['sale_date'])?></td>
                        <td><?= $row['invoice_number']?></td>
                        <td><?= $row['description']?></td>
                        <td><?= $row['quantity']?></td>
                        <td><?= $row['cost_per_ton'] ?></td>
                        <td><?= $row['selling_price']?></td>
                        <td><?= $row['subtotal']?></td>

                        <!-- empty td's -->
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <td><?=  '' ?></td>
                        <td><?= '' ?></td>
                        <td><?= ''  ?></td>
                        <td><?= '' ?></td>
                        <!-- end empty td's -->
                      </tr>
                    <?php endforeach ?>

                    <!-- 2. Expense Description, Expense Amount -->
                    <?php $expenses = getExpense($connection,$start_date, $end_date)?>
                    <?php foreach ($expenses as $exp): ?>
                      <tr>
                       <!-- render date  -->
                       <td><?= Dformat($exp['expense_date']) ?></td>
                       <!-- end render date -->
                       <td><?= '' ?></td>
                       <td><?= '' ?></td>
                       <td><?= '' ?></td>
                       <!-- <td><?= '' ?></td> -->
                       <td><?= '' ?></td>
                       <td><?= '' ?></td>
                       <td><?= '' ?></td>
                       <!-- render data here -->
                       <td><?= $exp['expense_description'] ?></td>
                       <td><?= $exp['expense_amount']  ?></td>
                       <!-- <end data rendering -->

                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>

                      </tr>
                    <?php endforeach ?>

                    <!-- 3. Bank, Amount Deposited -->
                    <?php $bank_depo = getBankDepo($connection,$start_date, $end_date)?>
                    <?php foreach ($bank_depo as $depo): ?>
                      <tr>
                        <!-- render date -->
                        <td><?= Dformat($depo['date_deposited'])?></td>
                        <!-- render date  -->
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <!-- <td><?= '' ?></td> -->
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <!-- empty td's -->
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <!-- end empty td's -->

                        <!-- render data here -->
                        <td><?= $depo['bank_name']?></td>
                        <td><?= $depo['amount_deposited']?></td>
                        <!-- end data rendering -->

                        <!-- empty td's -->
                        <td><?= '' ?></td>
                        <td><?= ''?></td>
                        <td><?= '' ?></td>
                        <!-- end empty td's -->
                      </tr>
                    <?php endforeach ?>

                    <!-- 4. Customer's Name, Amount Deposited -->
                    <?php $cust_depo = getCustDepo($connection,$start_date, $end_date)?>
                    <?php foreach ($cust_depo as $depo): ?>
                      <tr>
                        <!-- date -->
                        <td><?= Dformat($depo['date_deposited']) ?></td>
                        <!-- end date -->

                        <!-- empty td's -->
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <!-- <td><?= '' ?></td> -->
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <!-- end empty td's -->

                        <!-- render data here -->
                        <td><?=$depo['customer_name'] ?></td>
                        <td><?= $depo['amount_deposited'] ?></td>
                        <!-- end render data here -->
                        <td><?= '' ?></td>
                      </tr>
                    <?php endforeach ?>

                    <!-- 5.. B/f  -->
                    <?php $bbfs = getBBF($connection,$start_date, $end_date)?>
                    <?php foreach ($bbfs as $bbf): ?>
                      <tr>
                        <!-- date -->
                        <td><?= Dformat($bbf['date'])?></td>
                        <!-- end date -->
                        <!-- empty td's -->
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <td><?=  '' ?></td>
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <!-- <td><?= '' ?></td> -->
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <td><?= '' ?></td>
                        <td><?= ''?></td>
                        <td><?= ''?></td>
                        <!-- end empty td's -->
                        <!-- render here  -->
                        <td><?= $bbf['amount']?></td>
                        <!-- render here  -->
                      </tr>
                    <?php endforeach ?>
                  </tbody>

                </table>
              </div>
            </div>
          </div>
          <!-- </section> -->

        </div>
      </div>

      <div class="row sale-bottom" style = > <!-- row for the submit button and print invoice -->
        <div class="col-md-12">
          <form  action = "report.php" method = "GET"> >
            <input type="text" name="start_date" value ="<?= $start_date ?>"  hidden>
            <input type="text" name="end_date" value = "<?= $end_date?>" hidden>
           <button type="submit" id = 'print' style = 'padding:10px;font-size: 30px;position:fixed;bottom:10px;left:90%;height:60px;width: 60px;border-radius: 50%' class="btn btn-success img-rounded"><i class="glyphicon glyphicon-print"></i></button>
        </form>
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

    <script src="../plugins/chartjs/Chart.min.js"></script>

    <script type="text/javascript">

      $('document').ready(function(){
        $('.close').click(function(){
          $(this).parents('.box').slideToggle();
        });

        $('#show-stock-sales').click(function(){
          $('#modal_stock-qty-sold').modal();
        });

        // $('#print').click(function(e){
        //    window.location = 'https://localhost/nigeria'
        // });





        var areaChartData = {
          labels: <?php echo getStockDescAndQtysold($connection,$start_date,$end_date,1); ?> ,

          datasets: [
          {
            label: "Electronics",
            fillColor: "rgba(210, 214, 222, 1)",
            strokeColor: "rgba(210, 214, 222, 1)",
            pointColor: "rgba(210, 214, 222, 1)",
            pointStrokeColor: "#c1c7d1",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: <?php echo getStockDescAndQtysold($connection,$start_date,$end_date,2); ?>

          }
          ]
        };
        $('#show-stock-graph').click(function(){
          $('#stock_analysis_graph').modal();

// stock sales analysis 
var barChartCanvas = $("#barChart").get(0).getContext("2d");
var barChart = new Chart(barChartCanvas);
var barChartData = areaChartData;
barChartData.datasets[0].fillColor = "#00a65a";
barChartData.datasets[0].strokeColor = "#00a65a";
barChartData.datasets[0].pointColor = "#00a65a";
var barChartOptions = {
    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
    scaleBeginAtZero: true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines: true,
    //String - Colour of the grid lines
    scaleGridLineColor: "rgba(0,0,0,.05)",
    //Number - Width of the grid lines
    scaleGridLineWidth: 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines: true,
    //Boolean - If there is a stroke on each bar
    barShowStroke: true,
    //Number - Pixel width of the bar stroke
    barStrokeWidth: 2,
    //Number - Spacing between each of the X value sets
    barValueSpacing: 5,
    //Number - Spacing between data sets within X values
    barDatasetSpacing: 1,
    //String - A legend template
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
    //Boolean - whether to make the chart responsive
    responsive: true,
    maintainAspectRatio: true
  };

  barChartOptions.datasetFill = false;
  barChart.Bar(barChartData, barChartOptions);
});

      });

    </script>
  </body>
  </html>

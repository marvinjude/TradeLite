<?php
session_start();
$connection = include('../resources/conection.inc.php');
include_once('../functions/invoice_functions.php');
include_once('ctrl-dailysales.php');

//echo var_dump(getCashAtHand($connection,'2017-09-12','2017-09-12',2));

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
                <h4 class="modal-title">Show Analysis From 01/09/2017 - 23/09/2017</h4>
              </div>
              <div class="modal-body">


                <!-- sale graph > -->
                <div class="box box-success">
                  <!-- <div class="box-header with-border">
                    <h3 class="box-title">Bar Chart</h3>

                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                  </div> -->
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
                  <h4 class="modal-title">Show Analysis From 01/09/2017 - 23/09/2017</h4>
                </div>
                <div class="modal-body">


                  <!-- sale graph > -->
                  <div class="box box-success">

                    <div class="box-body">

                      <table id="layout-skins-list" class="table table-striped bring-up nth-2-center"
                      >
                      <thead>
                        <tr>
                          <th>Stock</th>
                          <th>Quantity Sold</th>
                        </tr>
                      </thead>
                      <tbody>

                        <tr>
                         <td>10 mm tiger </td>
                         <td>199</td>
                       </tr>

                       <tr>
                         <td>10 mm tiger </td>
                         <td>199</td>
                       </tr>

                       <tr>
                         <td>10 mm tiger </td>
                         <td>199</td>
                       </tr>

                       <tr>
                         <td>10 mm tiger </td>
                         <td>199</td>
                       </tr>

                       <tr>
                         <td>10 mm tiger </td>
                         <td>199</td>
                       </tr>

                       <tr>
                         <td>10 mm tiger </td>
                         <td>199</td>
                       </tr>

                       <tr>
                         <td>10 mm tiger </td>
                         <td>199</td>
                       </tr>


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
                       <input type="date" class="form-control" name="f_date" required="">
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

                     <input type="date" class="form-control" name="s_date" required=""> 
                   </div>
                 </div>

                 <div class="col-xs-12 col-md-2 col-xs-12 col-sm-12">
                  <input type="submit" value="Generate" name="generate_data" class=" btn btn-block btn " style="background-color: #3c8dbc; color:white">
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>

      <div class = 'row'>
        <div class = 'col-md-12'>
         <div class="box box-primary">
          <div class="box-header with-border ">
            <h3 class="box-title">Sales From <strong>11/03/2013</strong> to<strong>11/03/2013</strong>(Analysis) </h3>
            <span class = 'close'>&times</span>
          </div>
          <div class="box-body">
            <div class = 'table-responsive'>

              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Total</th>
                    <th>Customer Deposits </th>
                    <th>Balance BF </th>
                    <th>Expense</th> 
                    <th>Bank Deposit</th>
                    <th>Cash @ Hand</th>
                    <th>Start Date</th> 
                    <th>End Date</th>
                  </tr>
                </thead>

                <tbody>
                  <tr>
                   <td>10</td> 
                   <td>10</td>
                   <td>10</td> 
                   <td>10</td>
                   <td>10</td>
                   <td>10</td>
                   <td> 23/12/2017</td> 
                   <td>  23/12/2017</td>
                 </tr>
               </tbody>

             </table>
            
          </div>
           <button id = 'show-stock-graph' class = ' btn bg-navy pull-right'>
              Sales Graph <span class = 'glyphicon glyphicon-stats'></span>
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
    <div class="col-md-12 ">
      <!-- <section class="content"> -->
       <div class="box box-primary">
        <div class="box-header with-border ">
          <h3 class="box-title">Sales From <strong>(11/03/2013</strong> to<strong>11/03/2013)</strong> </h3>

        </div>
        <div class="box-body">
          <div class = 'table-responsive'>
            <table class="table table-striped bring-up nth-2-center" style="background-color: white">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>invoice Num</th>
                  <th>Stock Description</th>
                  <th>QTY</th>
                  <th>Ton Price</th>
                  <th>Selling Price</th> 
                  <th> sub total</th>
                  <th>Total</th>
                  <th>Amount Paid</th>
                  <th > expense</th>
                  <th>Bank Deposit</th>

                </tr>



              </thead>

              <tbody>
               <tr>
                <td>10/02/90</td>
                <td> 4567</td>
                <td >5678 </td>
                <td >456789</td>               
                <td > 456789 </td>
                <td > 567890</td>
                <td > 4567890</td>
                <td > 100000  </td>                 
                <td> 100000</td>
                <td>  567890-987</td>
                <td > 567890-0987</td>
              </tr>


              <!-- row 2 -->


              <tr>
                <td>10/02/90</td>
                <td> 4567</td>
                <td >5678 </td>
                <td >456789</td>               
                <td > 456789 </td>
                <td > 567890</td>
                <td > 4567890</td>
                <td > 100000  </td>                 
                <td> 100000</td>
                <td>  567890-987</td>
                <td > 567890-0987</td>
              </tr>

    <tr>
                <td>10/02/90</td>
                <td> 4567</td>
                <td >5678 </td>
                <td >456789</td>               
                <td > 456789 </td>
                <td > 567890</td>
                <td > 4567890</td>
                <td > 100000  </td>                 
                <td> 100000</td>
                <td>  567890-987</td>
                <td > 567890-0987</td>
              </tr>

                  <tr>
                <td>10/02/90</td>
                <td> 4567</td>
                <td >5678 </td>
                <td >456789</td>               
                <td > 456789 </td>
                <td > 567890</td>
                <td > 4567890</td>
                <td > 100000  </td>                 
                <td> 100000</td>
                <td>  567890-987</td>
                <td > 567890-0987</td>
              </tr>

                  <tr>
                <td>10/02/90</td>
                <td> 4567</td>
                <td >5678 </td>
                <td >456789</td>               
                <td > 456789 </td>
                <td > 567890</td>
                <td > 4567890</td>
                <td > 100000  </td>                 
                <td> 100000</td>
                <td>  567890-987</td>
                <td > 567890-0987</td>
              </tr>

                  <tr>
                <td>10/02/90</td>
                <td> 4567</td>
                <td >5678 </td>
                <td >456789</td>               
                <td > 456789 </td>
                <td > 567890</td>
                <td > 4567890</td>
                <td > 100000  </td>                 
                <td> 100000</td>
                <td>  567890-987</td>
                <td > 567890-0987</td>
              </tr>

                  <tr>
                <td>10/02/90</td>
                <td> 4567</td>
                <td >5678 </td>
                <td >456789</td>               
                <td > 456789 </td>
                <td > 567890</td>
                <td > 4567890</td>
                <td > 100000  </td>                 
                <td> 100000</td>
                <td>  567890-987</td>
                <td > 567890-0987</td>
              </tr>

                  <tr>
                <td>10/02/90</td>
                <td> 4567</td>
                <td >5678 </td>
                <td >456789</td>               
                <td > 456789 </td>
                <td > 567890</td>
                <td > 4567890</td>
                <td > 100000  </td>                 
                <td> 100000</td>
                <td>  567890-987</td>
                <td > 567890-0987</td>
              </tr>

                  <tr>
                <td>10/02/90</td>
                <td> 4567</td>
                <td >5678 </td>
                <td >456789</td>               
                <td > 456789 </td>
                <td > 567890</td>
                <td > 4567890</td>
                <td > 100000  </td>                 
                <td> 100000</td>
                <td>  567890-987</td>
                <td > 567890-0987</td>
              </tr>

                  <tr>
                <td>10/02/90</td>
                <td> 4567</td>
                <td >5678 </td>
                <td >456789</td>               
                <td > 456789 </td>
                <td > 567890</td>
                <td > 4567890</td>
                <td > 100000  </td>                 
                <td> 100000</td>
                <td>  567890-987</td>
                <td > 567890-0987</td>
              </tr>

                  <tr>
                <td>10/02/90</td>
                <td> 4567</td>
                <td >5678 </td>
                <td >456789</td>               
                <td > 456789 </td>
                <td > 567890</td>
                <td > 4567890</td>
                <td > 100000  </td>                 
                <td> 100000</td>
                <td>  567890-987</td>
                <td > 567890-0987</td>
              </tr>

                  <tr>
                <td>10/02/90</td>
                <td> 4567</td>
                <td >5678 </td>
                <td >456789</td>               
                <td > 456789 </td>
                <td > 567890</td>
                <td > 4567890</td>
                <td > 100000  </td>                 
                <td> 100000</td>
                <td>  567890-987</td>
                <td > 567890-0987</td>
              </tr>

                  <tr>
                <td>10/02/90</td>
                <td> 4567</td>
                <td >5678 </td>
                <td >456789</td>               
                <td > 456789 </td>
                <td > 567890</td>
                <td > 4567890</td>
                <td > 100000  </td>                 
                <td> 100000</td>
                <td>  567890-987</td>
                <td > 567890-0987</td>
              </tr>

                  <tr>
                <td>10/02/90</td>
                <td> 4567</td>
                <td >5678 </td>
                <td >456789</td>               
                <td > 456789 </td>
                <td > 567890</td>
                <td > 4567890</td>
                <td > 100000  </td>                 
                <td> 100000</td>
                <td>  567890-987</td>
                <td > 567890-0987</td>
              </tr>

                  <tr>
                <td>10/02/90</td>
                <td> 4567</td>
                <td >5678 </td>
                <td >456789</td>               
                <td > 456789 </td>
                <td > 567890</td>
                <td > 4567890</td>
                <td > 100000  </td>                 
                <td> 100000</td>
                <td>  567890-987</td>
                <td > 567890-0987</td>
              </tr>



            </tbody>

          </table>
        </div>
      </div>
    </div>
    <!-- </section> -->

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





  var areaChartData = {
    labels: ["10MM TIGER", "20MM TIGER", "March", "April", "May", "June", "July","10MM TIGER", "20MM TIGER", "March", "April", "May", "June", "July","10MM TIGER", "20MM TIGER", "March", "April", "May", "June", "July"],
    datasets: [
    {
      label: "Electronics",
      fillColor: "rgba(210, 214, 222, 1)",
      strokeColor: "rgba(210, 214, 222, 1)",
      pointColor: "rgba(210, 214, 222, 1)",
      pointStrokeColor: "#c1c7d1",
      pointHighlightFill: "#fff",
      pointHighlightStroke: "rgba(220,220,220,1)",
      data: [65, 59, 80, 81, 56, 55, 40,65, 59, 80, 81, 56, 55, 40,65, 59, 80, 81, 56, 55, 40]
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

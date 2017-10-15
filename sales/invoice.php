<?php session_start();

if (!isset($_SESSION['user'])){
  header("Location : ../index.php");
}

require_once('../functions/invoice_functions.php');
$connection = include('../resources/conection.inc.php');
  // check if the request method if get 
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if(empty($_GET['id'])){
    header('Location: sell.php');
  }
  $sale_id = mysqli_real_escape_string($connection,$_GET['id']);
  $invoice_data = getPreparedInvoiceData($sale_id,$connection);



    // var_dump(getSaleByID('150',$mysqli)) ;
  $sale = getSaleByID($sale_id,$connection);

  // var_dump($invoice_data);
  
}

?>



<!-- /the html -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Mukaz | Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../css/dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style type="text/css">
img{
 width: 100%;
 height:200px;
}

.margin-5{
  margin:5px;
}

.inline{
  display: inline;
}
td{
  text-transform: uppercase;
}

.centered{
  text-align: center;
}

.invoice-details{
  margin-bottom: 20px;
  /*border:1px solid whitesmoke;*/
  padding:10px ;
  font-family:pacifico;
  color:grey;
  font-size: 20px;
}

</style>
</head>
<body onload="print()">
  <div class = 'container' >
    <div class = 'row'>
      <div class = 'col col-md-10 col-lg-10 col-md-offset-1'> 
        <div class="wrapper">
          <!-- Main content -->
          <section class="invoice">
            <!-- title row -->
            <div class="row" style = "margin-bottom: 20px;">
              <div class="col-xs-12">
                <img src="../img/content/letterhead.png">
              </div>
              <!-- /.col -->
            </div>
            <!-- info row -->
            <!-- <other invoice details> -->
              <div class="row invoice-details" >
                <div class="col-md-4 col-sm-4 col-xs-4 centered">
                    <?php echo "Invoice Number: " .$sale['invoice_number']?>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-4 centered" >
                    <?php echo "Date: ". date('d-m-Y',strtotime($sale['sale_date']))?>
                  </h3>
                </div>

                <div class="col-md-4 col-sm-4  centered">
                  <?php echo "Customer: ". $sale['customer_name']?>
                </div>
                <!-- /.col -->
              </div>
              <!-- other invoive details -->

              <!-- Table row -->
              <div class="row">
                <div class="col-xs-12 table-responsive">
                  <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>Item Description</th>
                        <th>Price Per Ton</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Subtotal</th>
                      </tr>
                    </thead>
                    <tbody>

                      <!-- generate the invoicce data  -->
                      <?php foreach ($invoice_data as $row ): ?>

                        <tr>
                          <td><?=$row["S_N"]?></td>
                          <td><?=$row["description"]?></td>
                          <td><?=number_format($row["price_per_ton"])?></td> 
                          <td><?=$row["quantity"]?></td>
                          <td><?=number_format($row["rate"])?></td>
                          <td><?=number_format($row["subtotal"])?></td>

                        </tr>

                      <?php endforeach ?>

                      <!-- End of invoicd data genetration  -->

                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-xs-6">
                  <!-- <p class="lead">Payment Methods:</p>
                  <img src="../../dist/img/credit/visa.png" alt="Visa">
                  <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                  <img src="../../dist/img/credit/american-express.png" alt="American Express">
                  <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

                  <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr
                    jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                  </p> -->

                </div>
                <!-- /.col -->
                <div class="col-xs-6">

                  <div class="table margin-5">
                    <table class="table table-bordered table-striped">
                     <tr>
                      <th style="width:50%">Total</th>
                      <td><?php echo  number_format($sale['total'])?></td>
                    </tr>
                    <tr>
                      <th>Amount Paid </th>
                      <td><?php echo  number_format($sale['amount_paid']) ?></td>
                    </tr>
                    <tr>
                      <th>Outstanding</th>
                      <td> <?php echo getOutStandingBalance($sale_id,$connection)?></td>
                    </tr>
                  </table>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </section>
          <!-- /.content -->
        </div>
      </div>
    </div>
  </div>
  <!-- ./wrapper -->
</body>
</html>

<?php session_start();
  require_once('../functions/invoice_functions.php');
  // check if the request method if get 
   if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      if(!empty($_GET['id'])){
          header('Location:  ')
      }
  }
  
?>



<!-- /the html -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Invoice</title>
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

.centered{
  text-align: center;
}

.invoice-details{
  margin-bottom: 20px;
  border:1px solid whitesmoke;
  padding:10px ;
  font-family:pacifico;
  color:grey;
}

</style>
</head>
<body onload="">
  <div class = 'container' >
    <div class = 'row'>
      <div class = 'col col-md-10 col-md-offset-1'> 
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
                  <h3 class = 'inline'>Invoice Number:</h3> <h3 class='inline'>7878655</h3>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-4 centered" >
                  <h3 class = 'inline '>Date:</h3> <h3 class='inline align-right'>23/07/2017</h3>
                </div>

                <div class="col-md-4 col-sm-4  centered">
                  <h3 class = 'inline '>Customer Name:</h3> <h3 class='inline'>Jude</h3>
                </div>
                <!-- /.col -->
              </div>
              <!-- other invoive details -->

              <!-- Table row -->
              <div class="row">
                <div class="col-xs-12 table-responsive">
                  <table class="table table-striped">
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
                      
                      <tr>
                        <td>1</td>
                        <td>Need for Speed IV</td>
                        <td>247-925-726</td>
                        <td>Wes Anderson umami biodiesel</td>
                        <td>$50.00</td>
                        <td>$50.00</td>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>Monsters DVD</td>
                        <td>735-845-642</td>
                        <td>Terry Richardson helvetica tousled street art master</td>
                        <td>$10.70</td>
                        <td>$50.00</td>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>Call of Duty</td>
                        <td>455-981-221</td>
                        <td>El snort testosterone trophy driving gloves handsome</td>
                        <td>$64.50</td>
                        <td>$50.00</td>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>Grown Ups Blue Ray</td>
                        <td>422-568-642</td>
                        <td>Tousled lomo letterpress</td>
                        <td>$25.99</td>
                        <td>$50.00</td>
                      </tr>
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
                      <td>$250.30</td>
                    </tr>
                    <tr>
                      <th style="width:50%">Total</th>
                      <td>$250.30</td>
                    </tr>
                    <tr>
                      <th>Amount Paid </th>
                      <td>$10.34</td>
                    </tr>
                    <tr>
                      <th>Outstanding</th>
                      <td>$5.80</td>
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

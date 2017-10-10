	<?php 
	session_start();
	$connection = include('../resources/conection.inc.php');
	include_once('ctrl-dailysales.php');

	//if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if (isset($_GET['start_date']) && isset($_GET['end_date'])){
		$start_date  = $_GET['start_date'];
		$end_date = $_GET['end_date'];

		$start_date = mysqli_real_escape_string($connection,$start_date);
		$end_date = mysqli_real_escape_string($connection,$end_date);

	}else{
		die('<h1 style = "text-align:center">You cannot view this page</h1>');
	}



	//}

	?>


	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Mukaz | Report <?= $start_date .' to '. $end_date?></title>
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
		tr,td{
			white-space: nowrap;
		}

		.invoice-details{
			margin-bottom: 20px;
			/*border:1px solid whitesmoke;*/
			padding:10px ;
			font-family:pacifico;
			color:grey;
			font-size: 20px;
		}
		.table{
			max-width: 100%;
		}

	</style>
</head>
<body onload="print()">
	<div class = 'container-fluid' >
		<div class = 'row'>
			<div class="col-md-8 col-md-offset-2">
				<img src="../img/content/letterhead.png">
			</div>
		</div>



		<!-- Table row -->
		<div class="row">
			<div class="col-xs-8 ">
				<div class="box box-success box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">Sales Analysis From <?=$start_date?> to <?=$end_date?>  </h3>

					</div>

					<div class="box-body">

						<table class="table table-striped table-bordered">
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
									<td><?= $start_date ?></td>
									<td><?= $end_date ?></td>

								</tr>
							</tbody>

						</table>
					</div>

				</div>
			</div>
			<!-- /.col -->
		</div>



		<div class="row">
			<div class="col-xs-12 ">
				<!-- <div class = 'table-responsive'> -->
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
				<!-- </div> -->
			</div>
			<!-- /.col -->
		</div>


	</section>
	<!-- /.content -->
</div>
</div>
</div>
</div>
<!-- ./wrapper -->
</body>
</html>


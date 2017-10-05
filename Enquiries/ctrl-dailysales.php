<?php
// ________________________________________________________________________________________________________
//|return cash @ hand after some arithemetics (total sales amount + customer deposits + bbfs ) - (bankdep + allexpenses)|
//|pass in type = 1 for (sum) and type = 2 forrawdata |

function getCashAtHand($connection,$start_date,$end_date,$type = 1){

       //gets total BBF;
	$query1 = "SELECT SUM(balance_brought_foward.amount) AS SUM from balance_brought_foward where balance_brought_foward.date BETWEEN 
	'$start_date' AND '$end_date'";

      //get bank deposits
	$query2 = "SELECT SUM(bank_deposits.amount_deposited) AS SUM from bank_deposits where bank_deposits.date_deposited BETWEEN 
	'$start_date' AND '$end_date'";

      //get total sales
	$query3 = "SELECT SUM(sales.total)  AS SUM FROM sales WHERE sales.sale_date BETWEEN '$start_date' AND '$end_date'";

      //customer deposit
	$query4 = "SELECT SUM(amount_deposited) AS SUM from customer_deposits where date_deposited BETWEEN 
	'$start_date' AND '$end_date'";


      //expenses 
	$query5 = "SELECT SUM(expenses.expense_amount) AS SUM from expenses where expenses.expense_date BETWEEN 
	'$start_date' AND '$end_date'";


	$bbf = mysqli_fetch_assoc(mysqli_query($connection,$query1))['SUM'];
	$bank_deposits = mysqli_fetch_assoc(mysqli_query($connection,$query2))['SUM'];
	$total_sales  = mysqli_fetch_assoc(mysqli_query($connection,$query3))['SUM'];
	$customer_deposit = mysqli_fetch_assoc(mysqli_query($connection,$query4))['SUM'];
	$expenses = mysqli_fetch_assoc(mysqli_query($connection,$query5))['SUM'];

	if ($type == 1){
		$cash_at_hand = ($total_sales + $customer_deposit + $bbf) - ($bank_deposits + $expenses);
		return $cash_at_hand;

	}else if($type == 2){
		$raw_data = array('bbf'=>$bbf,
			'bank_deposits'=>$bank_deposits,
			'total_sales' =>$total_sales,
			'customer_deposit'=>$customer_deposit,
			'expenses' => $expenses
		);
		return $raw_data;
	}
}

//_______________________________________________________________________________________
//|when type =1 is passed (returns the stock description as javascript array
//|when type =2 is passed (return the stock qty sold as javascriprt array)
//|when type =3 is passes (return an assoc array of both description and quantity )
function getStockDescAndQtysold($connection,$start_date,$end_date,$type = 1){

	$query = "SELECT stocks.description, SUM(subsales.quantity) FROM subsales INNER JOIN stocks ON stocks.id = subsales.stock_id GROUP BY subsales.stock_id"
	$result =  mysqli_query($query);

	if ($type == 1){

	}elseif (condition) {
		# code...
	}elseif (condition) {
		# code...
	}



}

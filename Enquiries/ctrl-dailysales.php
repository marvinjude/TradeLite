<?php

//return(as mysqli_result_set) the data that should be dispalayed on the leftside of the table
function getSalesDataLeft($connection,$start_date, $end_date){
	$query =  "SELECT sales.sale_date,customers.customer_name,sales.invoice_number,stocks.description,stocks.cost_per_ton,subsales.quantity, subsales.selling_price,subsales.subtotal FROM sales INNER JOIN customers ON customers.id = sales.customer_id INNER JOIN subsales on sales.id = subsales.sale_id INNER JOIN stocks ON stocks.id = subsales.stock_id WHERE sales.sale_date BETWEEN 
	'$start_date' AND '$end_date' ORDER BY sales.invoice_number DESC";

	if ($result = mysqli_query($connection,$query)){
		$sales_data = array();
		while ($row = mysqli_fetch_assoc($result)){
			array_push($sales_data, $row);
		}

		return $sales_data;
	}

}


// return the total sales for those selected date
function getTotalSales($connection,$start_date, $end_date){
	$query = "SELECT SUM(sales.total) AS SUM FROM sales WHERE sales.sale_date BETWEEN '$start_date' 
	AND '$end_date'";
	if ($result = mysqli_query($connection,$query)){
		$array = mysqli_fetch_assoc($result);
		return $array["SUM"];
	}
}



//returns array of customername , Amount Deposited
function getCustDepo($connection,$start_date, $end_date){
	$query = "SELECT customer_deposits.date_deposited,customers.customer_name, customer_deposits.amount_deposited FROM customer_deposits INNER JOIN customers ON customers.id = customer_deposits.customer_id WHERE customer_deposits.date_deposited BETWEEN '$start_date' AND  '$end_date'";

	if ($result = mysqli_query($connection,$query)){
		$depoarr = array();
		while ($row = mysqli_fetch_assoc($result)){
			array_push($depoarr, $row);
		}

		return $depoarr;
	}
}


//return an array of bank name, amount deposited
function getBankDepo($connection,$start_date, $end_date){
	$query = "SELECT date_deposited, bank_name, amount_deposited FROM bank_deposits  WHERE date_deposited BETWEEN 
	'$start_date' AND  '$end_date'";

	if ($result = mysqli_query($connection,$query)){
		$bank_depo_arr = array();
		while ($row = mysqli_fetch_assoc($result)){
			array_push($bank_depo_arr, $row);
		}

		return $bank_depo_arr;
	}
}

//return an array of expense name, expense amount
function getExpense($connection,$start_date, $end_date){
	$query = "SELECT expense_date, expense_description, expense_amount FROM expenses WHERE expense_date BETWEEN 
	'$start_date' AND  '$end_date'";

	if ($result = mysqli_query($connection,$query)){
		$exp_arr = array();
		while ($row = mysqli_fetch_assoc($result)){
			array_push($exp_arr, $row);
		}

		return $exp_arr;
	}

}

//return an array of bbf amount
function getBBF($connection,$start_date, $end_date){
	$query = "SELECT date, amount FROM balance_brought_foward WHERE date BETWEEN '$start_date' AND  '$end_date'" ;
	if ($result = mysqli_query($connection,$query)){
		$bbf_arr = array();
		while ($row = mysqli_fetch_assoc($result)){
			array_push($bbf_arr, $row);
		}

		return $bbf_arr;
	}
}



// ________________________________________________________________________________________________________
//|return cash @ hand after some arithemetics (total sales amount + customer deposits + bbfs ) - (bankdep + allexpenses)|
//|pass in type = 1 for (sum) and type = 2 forrawdata |

function getRawdata($connection,$start_date,$end_date){

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
	$bbf = is_null($bbf )? 0 : $bbf ;

	$bank_deposits = mysqli_fetch_assoc(mysqli_query($connection,$query2))['SUM'];
	$bank_deposits = is_null($bank_deposits)? 0 : $bank_deposits ;

	$total_sales  = mysqli_fetch_assoc(mysqli_query($connection,$query3))['SUM'];
	$total_sales = is_null($total_sales)? 0 : $total_sales ;

	$customer_deposit = mysqli_fetch_assoc(mysqli_query($connection,$query4))['SUM'];
	$customer_deposit = is_null($customer_deposit )? 0 : $customer_deposit ;

	$expenses = mysqli_fetch_assoc(mysqli_query($connection,$query5))['SUM'];
	$expenses = is_null($expenses )? 0 : $expenses ;
	


	$raw_data = array('bbf'=>$bbf ,
		'bank_deposits'=>$bank_deposits ,
		'total_sales' =>$total_sales,
		'customer_deposit'=>$customer_deposit,
		'expenses' => $expenses
	);
	return $raw_data;
}


function getCashAtHand($raw_data){
	$cash_at_hand = ($raw_data['total_sales'] + $raw_data ['customer_deposit'] + $raw_data ['bbf'])
	- ($raw_data['bank_deposits'] + $raw_data ['expenses']);
	return $cash_at_hand;
}
//_______________________________________________________________________________________
//|when type =1 is passed (returns the stock description as javascript array
//|when type =2 is passed (return the stock qty sold as javascriprt array)
//|when type =3 is passes (return an assoc array of both description and quantity )
function getStockDescAndQtysold($connection,$start_date,$end_date,$type = 1){

	$query = "SELECT sales.sale_date,stocks.description, SUM(subsales.quantity) AS SUM FROM subsales INNER JOIN stocks ON stocks.id = subsales.stock_id inner join sales on subsales.sale_id = sales.id   WHERE sales.sale_date BETWEEN '$start_date' AND '$end_date' GROUP BY subsales.stock_id ORDER BY subsales.quantity DESC";

	$result =  mysqli_query($connection,$query);

	if ($type == 1){
		$num_rows = mysqli_num_rows($result)-1;
		$desc = '[';
		while ($row = mysqli_fetch_assoc($result)){
			$desc .= "'" . $row['description'] . "'";
			if($num_rows > 0){
				$desc .= ',';
			}
			
			$num_rows--;
		}
		$desc.= ']';	
		return $desc;
	}
	elseif ($type == 2) {
		$num_rows = mysqli_num_rows($result)-1;
		$qty = '[';
		while ($row = mysqli_fetch_assoc($result)){
			$qty .= " ' " . $row['SUM'] ."'";
			if($num_rows > 0){
				$qty .= ',';
			}
			
			$num_rows--;
		}
		$qty.= ']';	
		return $qty;
	}

	elseif ($type == 3) {
		$array = array();
		while ($row = mysqli_fetch_assoc($result)){
			array_push($array,$row);

		}
		return $array;
	}

}
function Dformat($date_str){
     return date("d/m/Y",strtotime($date_str));
}
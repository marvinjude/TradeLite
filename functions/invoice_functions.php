<?php


//get sale id when invoice number is supplied
function getSaleId($invoice_num,$mysqli){
	$query = "SELECT id FROM sales WHERE invoice_number = $invoice_num";
	if ($result = mysqli_query($mysqli,$query)){
		return mysqli_fetch_assoc($result)['id'];
	}else{
		printf("Notice: %s", mysqli_error($mysqli));
		return false;
	}
}


function getOutStandingBalance($sale_id,$mysqli){
	if ($sale = getSaleByID($sale_id,$mysqli)){
		$outstanding =  $sale['total'] - $sale['amount_paid'] ;
		return $outstanding;
	}
}

function getSaleByID($sale_id,$mysqli){

	$query = "SELECT * FROM sales INNER JOIN customers ON
	customers.id = sales.customer_id WHERE sales.id = '$sale_id' ";

	if ($result = mysqli_query($mysqli,$query)){
		return mysqli_fetch_assoc($result);
	}else{
		printf("Notice: %s", mysqli_error($mysqli));
		return false;
	}

}



function reduceStockLevel($connection,$data){
	$subsales = array();
	foreach ($data->sales as $subsaledata){
		array_push($subsales, $subsaledata);
	}  

	for($i = 0; $i < count($subsales); $i++){
		$this_stock_quantity = $subsales[$i]->quantity;
		$this_stock_id  = $subsales[$i]->stock_id;
		$old_quantity = getStockquantity($this_stock_id,$connection);
		$new_quantity = $old_quantity - $this_stock_quantity;
		setStockQuantity($this_stock_id,$new_quantity,$connection);
	}
}



//checks if the quantity about to be purched for each stock is valid :return true elsen return message 
function checkStocksAvailability($data,$connection){
	$subsales = array();
	$error_message = '';

	foreach ($data->sales as $subsaledata){
		array_push($subsales, $subsaledata);
	}  



	for($i = 0; $i < count($subsales); $i++){
		$this_stock_quantity = $subsales[$i]->quantity;
		$this_stock_id  = $subsales[$i]->stock_id;
		$old_quantity = getStockquantity($this_stock_id,$connection);

		if ($old_quantity < $this_stock_quantity){
			$error_message .= sprintf("Eroor! There are only %d %s in stock \n", 
				$old_quantity, getStockDescription($this_stock_id,$connection));
		}
		
	}

	if($error_message == ''){
		// means all stock quantity are needed
		return '';
	}else {
		return $error_message;
	}
}


function createNewSale($mysqli,$theJson){

	$query = "INSERT INTO sales (id, customer_id, sale_date, invoice_number, total, amount_paid,supply_status)
	VALUES (NULL, '$theJson->customer_id','$theJson->sale_date', '$theJson->invoice_number',
	'$theJson->total','$theJson->amount_paid', $theJson->supply_status)";

	
	if($mysqli->query($query))
	{

        //store debt in table if payment is incomplete
        if($theJson->amount_paid < $theJson->total)
        {
        	storeDebt($mysqli,$theJson->customer_id, $theJson->invoice_number,$theJson->amount_paid
        		,$theJson->total,$theJson->sale_date);
        }

		//store sale_id in session last_sale_id
	   $_SESSION['last_sale_id'] = $mysqli->insert_id;
		return true;
	}
	else{
		echo mysqli_error($mysqli);
		return false;
	}

 }


function storeDebt($mysqli,$customer_id,$invoice_number, $amount_paid,$total,$date){
	$debt = $total - $amount_paid; //cast this to integer to stop unimpotant balances from being debt
    $query = "INSERT INTO debtors (id, customer_id,amount,invoice,debt_date) 
              VALUES(NULL,'$customer_id','$debt', '$invoice_number','$date')";
    if($mysqli->query($mysqli,$query))
    {
    	return true;
    }
    else{
    	return false;
    }
}


function storeSubsales($mysqli,$theJson){
	if (!$stmt = $mysqli->prepare("INSERT INTO subsales (stock_id, quantity, subtotal,selling_price,price_per_ton,sale_id) VALUES (?,?,?,?,?,?)")){
		echo 'unable to prepare statement';
	}


	$stmt->bind_param("dddddd", $stock_id, $stock_quantity, $total,$selling_price,
		$price_per_ton,$sale_id);

        //get the last sale id stored into session
	$last_id = $_SESSION['last_sale_id'];
	foreach($theJson->sales as $sale){
		$stock_id = $sale->stock_id;
		$stock_quantity = $sale->quantity ;
		$total = $sale->subtotal;
		$price_per_ton = $sale->price_per_ton;
		$selling_price =  getRate($total,$stock_quantity);
		$sale_id = $last_id;
		$stmt->execute();
	}
	if($stmt){
		return true;
	}else{
		return false;
	}
	$stmt->close();
}


//sums up a given field name in an array of arrays e.g sums all subtotals in an array of subsales and return total
//arraay of array = multidimensional array
function getTotalFieldVal($arrayofarrays,$field){
	$sum = 0;
	foreach ($arrayofarrays as $array) {
		$sum  = $sum  +  $array[$field];
	}
	return $sum;
}

function getPreparedInvoiceData($sale_id,$mysqli){
	$result = getStocksPurchases($mysqli,$sale_id);
	$i = 0;
    $invoice_data = array(); // will contain whole invoice data after array push complete

    while ($row = mysqli_fetch_assoc($result)) {
    	$invoice_row = array(
    		"S_N" => ++$i,
    		"quantity" => $row['quantity'],
    		"price_per_ton" => $row['price_per_ton'],
    		"rate" => round(($row['subtotal'] / $row['quantity']),2),
    		"subtotal"  => $row['subtotal'],
    		"description" => $row['description']
    	);
   	array_push($invoice_data,$invoice_row);  //push result row to array
   	
   }
   return $invoice_data;

}



//genetated the data that needs to be rendered on the invoice for the last saleID
//gets :description,price per ton,quantity
function getStocksPurchases($mysqli,$sale_id){
	$query = "SELECT stocks.description,subsales.price_per_ton,subsales.quantity,subsales.subtotal FROM sales INNER join subsales ON sales.id = subsales.sale_id INNER JOIN stocks ON stocks.id = subsales.stock_id WHERE sales.id = '$sale_id'";

	if($result = mysqli_query($mysqli,$query)){
		return $result ;
	}
	else{
		printf("Notice: %s", mysqli_error($mysqli));
	}
	
}


function getStockDescription($stock_id,$mysqli){
	$query = "SELECT description FROM stocks WHERE id = '$stock_id'";
	if ($result = mysqli_query($mysqli,$query)){
		return mysqli_fetch_assoc($result)['description'];
	}else{
		printf("Notice: %s", mysqli_error($mysqli));
	}
}

//update the stock Quantity --to be used to reduce stock level after successfull sale
function setStockQuantity($stock_id, $quantity,$mysqli){
	$query = "UPDATE stocks SET quantity_in_store = '$quantity' WHERE id = '$stock_id' ";
	if(mysqli_query($mysqli,$query)){
		return true;
	}else{
		printf("Notice: %s", mysqli_error($mysqli));
	}
}

//gets current stock quantity
function getStockQuantity($stock_id,$mysqli){
	$query = "SELECT quantity_in_store FROM stocks WHERE id = '$stock_id'";
	if ($result = mysqli_query($mysqli,$query)){
		return mysqli_fetch_assoc($result)['quantity_in_store'];
	}else{
		printf("Notice: %s", mysqli_error($mysqli));
	}

}

function getCostPerTon($stock_id,$mysqli){
	$query = "SELECT cost_per_ton FROM stocks WHERE id = '$stock_id'";
	if ($result = mysqli_query($mysqli,$query)){
		return mysqli_fetch_assoc($result)['cost_per_ton'];
	}else{
		printf("Notice: %s", mysqli_error($mysqli));
	}
}

//store (in_session)and returns the last inserted id ... should be called after sales insertion
// function storeSaleID($mysqli){
// 	$id = $mysqli->insert_id;
// 	$_SESSION['last_sale_id'] = $id;
// }

    // formulae (total sales) = (price per ton/ quantity per ton) * quantity sold  

    //                             50     /   20    *      100   == 250

// get total for each subsale using the above formula
function getTotal($price_per_ton,$quantity_per_ton,$quantity_sold){
	return ($price_per_ton / $quantity_per_ton) * $quantity_sold;
}

function getRate($total,$quantity_sold){
	return ($total/$quantity_sold);
}

function getLastIdFromSales($mysqli){
	$query = "SELECT MAX(id) FROM sales";
	if ($result = mysqli_query($mysqli,$query)){
		return mysqli_fetch_assoc($result)['MAX(id)'];
	}else{
		printf("Notice: %s", mysqli_error($mysqli));
	}
}

// gets the last id and select the the invoice number associated with it + 1 
function genNewInvoiceNumber($mysqli){
	$query = "SELECT * FROM sales";
	$result = mysqli_query($mysqli,$query);
	if(mysqli_num_rows($result) == 0){
		return 1000;
	}

	$query = "SELECT MAX(id) FROM sales";
	$result = mysqli_query($mysqli,$query);
	$last_id = mysqli_fetch_assoc($result)['MAX(id)'];

	$query = "SELECT invoice_number FROM sales WHERE id = '$last_id'";
	$result = mysqli_query($mysqli,$query);
	$last_invoice_num = mysqli_fetch_assoc($result)['invoice_number'];


	$query = "SELECT MAX(invoice_number) FROM sales";
	$result = mysqli_query($mysqli,$query);
	$max_invoice_num = mysqli_fetch_assoc($result)['MAX(invoice_number)'];

	if($last_invoice_num >= $max_invoice_num ){
		return  $last_invoice_num +  1;
	}else{
		return  $max_invoice_num +  1;
	}

}


function get2Dec($string){
 $vals = explode('.', $string);
 $vals = $vals[0]. "." .substr($vals[1], 0, 2);
 return (float) $vals;
}



?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
 <button class = 'press'>1</button>>
 <button class = 'press'>2</button>>
 <button class = 'press'>3</button>>
 <button class = 'press'>4</button>>
</body>
</html>



<?php
session_start();
//connection 






$mysqli = new Mysqli('localhost', 'root','','nigeria');

//data
$theJson = json_decode('{
	"customer_id": 11,
	"sale_date" : "2017-09-12",
	"invoice_number": 60002,
	"seller_id": 1,
	"total": 10,
	"sales":[
		{"stock_id": "200", "quantity": "5000" ,"subtotal": "9087"},
		{"stock_id": "6" , "quantity": "5000" , "subtotal": "789"},
		{"stock_id": "200" , "quantity": "5000" ,"subtotal" :"67890"}
	],
	"amount_paid" : "9000"
}') or $_POST['data'];


//echo genNewInvoiceNumber($mysqli);

// var_dump(getPreparedInvoiceData('46',$mysqli));

// echo getTotalFieldVal(getPreparedInvoiceData('46',$mysqli),"quantity");

function createNewSale($mysqli,$theJson){
	$query = "INSERT INTO sales (id, customer_id, seller_id, sale_date, invoice_number, total, amount_paid)
	VALUES (NULL, '$theJson->customer_id', '$theJson->seller_id', '$theJson->sale_date', '$theJson->invoice_number', 
	'$theJson->total', '$theJson->amount_paid')";
	if($mysqli->query($query)){

		//store sale_id in session last_sale_id
		storeSaleID($mysqli);
		
	}else{echo mysqli_error($mysqli);}
}



function storeSubsales($mysqli,$theJson){
	if (!$stmt = $mysqli->prepare("INSERT INTO subsales (stock_id, quantity, subtotal,sale_id) VALUES (?, ?, ?,?)")){
		echo 'unable to prepare statement';
	}


	$stmt->bind_param("dddd", $stock_id, $stock_quantity, $total, $sale_id);

        //get the last sale id stored into session
	$last_id = $_SESSION['last_sale_id'];
	foreach($theJson->sales as $sale){
		$stock_id = $sale->stock_id;
		$stock_quantity = $sale->quantity ;
		$total = $sale->subtotal;
		$sale_id = $last_id;
		$stmt->execute();

	}
	if($stmt){
		substactStockQuantity($stock_id, $quantity);
	}
	$stmt.close();
}



//sums up a given field name in an array of arrays e.g sums all subtotals in an array of subsales and return total
//arraay of array = multidimensional array
function getTotalFieldVal($arrayofarrays,$field){
	$sum = 0;
	foreach ($arrayofarrays as $array) {
		$sum  = $sum  +  (int)$array[$field];
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
    		"quantity" => (int)$row['quantity'],
    		"price_per_ton" => $row['cost_per_ton'],
    		"rate" => getRate(getTotal($row['cost_per_ton'],45,$row['quantity']),$row['quantity']),
    		"total"  => getTotal($row['cost_per_ton'],45,$row['quantity']),
    		"description" => $row['description']
    	);
   	array_push($invoice_data,$invoice_row);  //push result row to array
   	
   }
   return $invoice_data;

}



//genetated the data that needs to be rendered on the invoice for the last saleID
//gets :description,price per ton,quantity
function getStocksPurchases($mysqli,$sale_id){
	$query = "SELECT stocks.description,stocks.cost_per_ton,subsales.quantity FROM sales INNER join subsales ON sales.id = subsales.sale_id INNER JOIN stocks ON stocks.id = subsales.stock_id WHERE sales.id = '$sale_id'";

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
	if(!mysqli_query($mysqli,$query)){
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
function storeSaleID($mysqli){
	$id = $mysqli->insert_id;
	$_SESSION['last_sale_id'] = $id;
	return $id;
}

    // formulae (total sales) = (price per ton/ quantity per ton) * quantity sold  

    //                             50     /   20    *      100   == 250

// get total for each subsale using the above formula
function getTotal($price_per_ton,$quantity_per_ton,$quantity_sold){
	return ($price_per_ton / $quantity_per_ton) * ($quantity_sold);
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



<?php 
$connection = include('../resources/conection.inc.php');
include_once('../functions/invoice_functions.php');
$_SESSION['last_sale_id'] = 1;
$data = json_decode($_POST['data']);



$stocks_status = checkStocksAvailability($data,$connection);
 
if($stocks_status == ''){
	if(createNewSale($connection, $data)){
		if(storeSubsales($connection,$data)){
			reduceStockLevel($connection,$data);
			echo "All Done";
		}
	}
	
}else{
	die($stocks_status);
}



?>
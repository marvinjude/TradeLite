<?php session_start();
$connection = include('../resources/conection.inc.php');
include_once('../functions/invoice_functions.php');
// this file is reponsible for pulling pout the sales data inputed in the session by sale_ajax_manager


//store the action from ajax req into variable

header("Content-Type: application/json");
if ($_POST['action'] == 'SAVE'){

    // store amount paid to session
	$_SESSION['amount_paid'] = $_POST['amount_paid'];
	$_SESSION['total'] = getTotalFieldVal($_SESSION['sales'],'subtotal');	
	$_SESSION['supply_status'] = (int) $_POST['supply_status'];
    $supply_status = $_SESSION['supply_status'];
    // create the json that contains all thge sails data 
	$json = json_encode($_SESSION);
	$theJson = json_decode($json);

	createNewSale($connection,$theJson);
	$last_id = $_SESSION['last_sale_id'];
	storeSubsales($connection,$theJson);
	  if($supply_status == '1'){
         reduceStockLevel($connection,$theJson);
	  }
	  
	// // send the a location where js will navigate to
	echo json_encode(array('status'=>'success', 'new_location'=>'invoice.php?id='. $last_id));

}
?>
<?php session_start();
if(!isset($_SESSION['user'])){
	header("Location : ../index.php");
}

$connection = include('../resources/conection.inc.php');
include_once '../functions/completepayment_functions.php';
if (isset($_POST['sale']) && isset($_POST['amount'])){
	$sale_id = trim($_POST['sale']);
	$amount = trim($_POST['amount']);
	if(setNewPayment($connection,$sale_id,$amount)){
		$_SESSION['incremented_amt_paid'] = "done";
	    header("Location: ../enquiries/debtors.php");	
	}
}

?>
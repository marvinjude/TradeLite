<?php session_start();
if(!isset($_SESSION['user'])){
	header("Location : ../index.php");
}

$connection = include('../resources/conection.inc.php');
include_once '../functions/completepayment_functions.php';
if (isset($_GET['sale'])){
	$sale_id = $_GET['sale'];
   if(markPaymentCompleted($connection,$sale_id)){
   	 $_SESSION['payment_marked_completed'] = "marked";
   	  header("Location: ../enquiries/debtors.php");
   }
}

?>
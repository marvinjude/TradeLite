<?php session_start();
$connection = include('../resources/conection.inc.php');
include_once '../functions/completepayment_functions.php';
if (isset($_GET['sale'])){
	$sale_id = $_GET['sale'];
   if(markPaymentCompleted($connection,$sale_id)){
   	  header("Location: ../enquiries/debtors.php");
      $_SESSION['payment_marked_completed'] = "marked";
   }
}

?>
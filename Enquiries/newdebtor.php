<?php
	$connection = include('../resources/conection.inc.php');
	if (!empty($_POST)){

		$customer_id =  $_POST['customer'];
		$date =  $_POST['date']; 
		$date  = date("Y-m-d",strtotime($date));
		$amout_owed =  $_POST['amount_owed'];

	     //create the debt
		create_new_debt($connection,$customer_id,$date,$amout_owed);

	}


	 // function to create debt 
	function create_new_debt($mysqli,$customer_id,$date,$amount_owed){
		$query = "INSERT INTO debtors (id,customer_id,amount,invoice,debt_date) VALUES
		         (NULL,'$customer_id','$amount_owed',NULL,'$date')";

		if($mysqli->query($query)){
			return true;
		}else{
			echo mysqli_error($mysqli);
			return false;
		}
	}
?>
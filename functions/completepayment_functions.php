<?php
function markPaymentCompleted($mysqli,$sale_id){
	$query = "UPDATE sales SET amount_paid = total WHERE id = '$sale_id'";
	if(mysqli_query($mysqli,$query)){
		return true;
	}else{
		return false;
	}
}

//this function add to the amount _paid field for a sale id in tyhe db
function setNewPayment($mysqli,$sale_id,$amount_paid ){
	$query = "UPDATE sales SET amount_paid = amount_paid + $amount_paid WHERE id = '$sale_id'";
	echo $query;
	if(mysqli_query($mysqli,$query)){
		return true;
	}else{
		trigger_error(mysqli_error($mysqli));
		return false;
	}
}

?>
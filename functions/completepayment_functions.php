<?php
function markPaymentCompleted($mysqli,$debt_id){
	$query = "UPDATE `debtors` SET `amount` = '0' WHERE `id` = '$debt_id'";
	if(mysqli_query($mysqli,$query)){
		return true;
	}else{
		echo mysqli_error($mysqli);
		return false;
	}
}

// reduce the customers debt by @params $amount_paid
function setNewPayment($mysqli,$debt_id,$amount_paid ){
	$query = "UPDATE `debtors` SET `amount` = amount - $amount_paid WHERE `id` = '$debt_id'";
	if(mysqli_query($mysqli,$query)){
		return true;
	}else{
		trigger_error(mysqli_error($mysqli));
		return false;
	}
}

?>
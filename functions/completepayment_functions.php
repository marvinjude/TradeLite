<?php

function markPaymentCompleted($mysqli,$sale_id){
	$query = "UPDATE sales SET amount_paid = total WHERE id = '$sale_id'";
	if(mysqli_query($mysqli,$query)){
		return true;
	}else{
		return false;
	}
}

?>
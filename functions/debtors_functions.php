<?php
//returns result
function getAllDebtors($mysqli){
	$query = "SELECT
	sales.id,
	customers.customer_name,
	customers.customer_phone,
	sales.invoice_number,
	total-amount_paid ,
	sales.sale_date
	FROM
	`sales`
	INNER JOIN
	customers ON customers.id = sales.customer_id
	WHERE
	sales.amount_paid < sales.total";

	if ($result = mysqli_query($mysqli,$query)){
		return $result;
	}else{
		 trigger_error($mysqli_error($mysqli));
	}
}
function getNumDebtors($mysqli){
	$query = "SELECT DISTINCT customers.customer_phone FROM sales INNER JOIN customers ON  customers.id = sales.customer_id WHERE sales.amount_paid < sales.total";

	if($result = mysqli_query($mysqli,$query)){
		$count = mysqli_num_rows($result);
		return $count;
	}else{
	     trigger_error(mysqli_error($mysqli));
		return false;
	}
}

function getTotalDebt($mysqli){
	$query =  "SELECT SUM(total-amount_paid) AS total_debt FROM sales WHERE amount_paid < total";
	if($result  = mysqli_query($mysqli,$query)){
      $result = mysqli_fetch_assoc($result);
      return $result['total_debt'];
	}else{
	     trigger_error(mysqli_error($mysqli));
		return false;
	}
}



?>
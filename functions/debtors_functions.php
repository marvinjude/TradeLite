<?php
//new Implementation for getAllDebtors, getNumDebtors, getTotalDebt

function getAllDebtors($mysqli){
   $query = "SELECT customers.customer_name AS customer_name, debtors.id AS debt_id, customers.customer_phone AS   
             customer_phone, debtors.invoice AS invoice, debtors.debt_date AS debt_date, debtors.amount AS amount
             FROM debtors INNER JOIN customers ON debtors.customer_id = customers.id WHERE amount > 0";

   if ($result = $mysqli->query($query)){
   	  return $result;
   }else{
   	 echo mysqli_error($mysqli);
   	 return false;
   }
}

function getNumDebtors($mysqli){
  $query = "SELECT COUNT(id) AS count FROM debtors WHERE amount > 0";
    if ($result = $mysqli->query($query)){
    	$count = mysqli_fetch_assoc($result)['count']; 
    	return $count;
    }

}

function getTotalDebt($mysqli){
   $query = "SELECT SUM(amount) AS total_debt FROM debtors";
    if ($result = $mysqli->query($query)){
        $totaldebt = mysqli_fetch_assoc($result)['total_debt']; 
    	return $totaldebt;
    }
}



/*
 *previous implemntation for getAllDebtors, getNumDebtors, getTotalDebt
 *
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

*/

?>
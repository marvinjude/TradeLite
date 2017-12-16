<?php session_start();
$connection = include('../resources/conection.inc.php');
include_once('../functions/invoice_functions.php');

// this file is reponsible for storing the info for the  sales in the session and dooing all form of user interaction this the user interface


switch ($_POST['action']) {


    case 'SAVE_AMOUNT_PAID':
       $_SESSION['amount_paid'] = $_POST['amount_paid'];
       echo 'amount paid saved to session ';
     break;


    case 'GET_QTY_AND_TOTAL':
        header("Content-Type: application/json");

         if(!isset($_SESSION['sales']) || empty($_SESSION['sales'])){
             echo json_encode(array('quantity'=> 0, 'total'=> 0));
         }else{
         	$total_qty = getTotalFieldVal($_SESSION['sales'],'subtotal');
            $total_amount = getTotalFieldVal($_SESSION['sales'], 'quantity');
            echo json_encode(array('quantity'=>$total_qty, 'total'=> round($total_amount,2)));
         } 
    break;

	case 'DELETE_INDEX':
	$index = $_POST['index'];
	unset($_SESSION['sales'][$index]);
	var_dump($_SESSION['sales']);
	break;

	case 'DELETE_ALL':
	if(isset($_SESSION['sales'])){
		unset($_SESSION['sales']);
	}
	break;

	case 'SETDATE':
	$_SESSION['sale_date'] = $_POST['sale_date'];
	echo "the session for date is set";
    break;

	case 'SETINVOICENUM':
	$_SESSION['invoice_number'] = $_POST['invoice_number'];
	echo "the session for invoice is set";
	break;

    // or add to cart 
	case 'SETCUSTOMERID':
	$_SESSION['customer_id'] = $_POST['customer_id'];
	if($debtobject = customerIsDebtor($connection,$_POST['customer_id'])){
		//if a debtobject is returned send to client
        echo json_encode($debtobject);
	}
	break;

	case 'STORESUBSALE':
	header("Content-Type: application/json");

	$s_id = trim($_POST['stock_id']);
	$q_sold = trim($_POST['quantity_sold']);
	$q_per_ton = trim($_POST['quantity_per_ton']);
	$s_price_per_ton = trim($_POST['price_per_ton']);
	$subtotal = getTotal($s_price_per_ton,$q_per_ton,$q_sold); // this is the subtotal for this stock purchase
	$s_desc = getStockDescription($s_id,$connection);

	$status = checkQty($connection,$s_id,$q_sold);

	// if ($status  == ''){  mukaz stated that they want stock level to decrease even if its 0,
	// so here i stoped a check on the quantity

		if(!isset($_SESSION['sales'])){
			$_SESSION['sales'] = array();     // if empty initialixe with emoty array
		}

		array_push($_SESSION['sales'], array(
			"stock_id" => $s_id, 
			"quantity" => $q_sold,
			"subtotal"=> round($subtotal,2),
			"price_per_ton" => $s_price_per_ton
		));

		
		$pushed_index = end(array_keys($_SESSION['sales']));


		echo json_encode(
			array("status" => "success",
		           "description"=> $s_desc,
		           "quantity"=> $q_sold , 
		           "subtotal" =>round($subtotal,2),
		           'rmv_index' => $pushed_index,
		           "price_per_ton" => $s_price_per_ton,
		           "qty_status_message" => $status
		        ));
   
	 break ;
}



function checkQty($connection,$stock_id,$quantity){
	$error_message = '';

	$old_quantity = getStockquantity($stock_id,$connection);

	if ($old_quantity < $quantity){
		$error_message = sprintf("Remember Your Stock Level For %s Is Low And Will Be Reduced To %d",
		 getStockDescription($stock_id,$connection), $old_quantity - $quantity);	
	}

	if($error_message == ''){
		return '';
	}else {
		return $error_message;
	}
}

function customerIsDebtor($connection,$customer_id){
	$query = "SELECT SUM(amount) as amount, customers.customer_name AS name FROM `debtors` INNER JOIN customers ON debtors.customer_id = customers.id  WHERE customer_id = '$customer_id'";

	if($result = mysqli_query($connection,$query)){
		$debt_arr = mysqli_fetch_assoc($result);
		return [
			'name'=> $debt_arr['name'],
			'amount' => $debt_arr['amount']
		];
	}else{
		trigger_error(mysqli_error($connection));
		return false;
	}

}














































// $_SESSION['last_sale_id'] = 1;
// $data = json_decode($_POST['data']);



// $stocks_status = checkStocksAvailability($data,$connection);

// if($stocks_status == ''){
// 	if(createNewSale($connection, $data)){
// 		if(storeSubsales($connection,$data)){
// 			reduceStockLevel($connection,$data);
// 			echo "All Done";
// 		}
// 	}

// }else{
// 	die($stocks_status);
// }



?>
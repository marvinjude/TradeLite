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
	echo "the session for customer id  is set";
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

	if ($status  == ''){

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


		echo json_encode(array("status" => "success", "description"=> $s_desc, "quantity"=> $q_sold , "subtotal" =>round($subtotal,2),'rmv_index' => $pushed_index,"price_per_ton" => $s_price_per_ton));
			
	}else{
        echo json_encode(array("status" => "error",  "desc" => $status));
	}
   
	 break ;
}



function checkQty($connection,$stock_id,$quantity){
	$error_message = '';

	$old_quantity = getStockquantity($stock_id,$connection);

	if ($old_quantity < $quantity){
		$error_message = sprintf("Eroor! There are only %d %s in stock", 
			$old_quantity, getStockDescription($stock_id,$connection));
	}

	if($error_message == ''){
		return '';
	}else {
		return $error_message;
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
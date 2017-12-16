<?php

  $connection = include('../resources/conection.inc.php');
  $sales = getAllSales($connection);


  if(isset($_GET['sid'])){
    $sale_id = trim($_GET['sid']);
    removeSaleBySaleId($connection,$sale_id);
    header("Location:sales.php");
    exit();
  }

  if(isset($_POST['iid'])){
   $iid  = trim($_POST['iid']);
   if(removeSaleByInvoiceNum($connection,$iid)){
     if($mysqli->affected_rows > 0){
       echo json_encode(['status' => 1]);
     }else{
       echo json_encode(['status' => 0]);
    }
  }
}

  function removeSaleBySaleId($connection,$sale_id){
    $query = "DELETE FROM `sales` WHERE `id` = '$sale_id'";
    if(mysqli_query($connection,$query)){
      return true;
    }else{
      trigger_error(mysqli_error($connection));
     return false;
   }
 }

 //forces an elises on on this number
 function forceElipses($number){
  $number = string($number);
    if(count($number) > 5){
      return substr($number, 0,5);
    }
 }

 function removeSaleByInvoiceNum($connection,$invoice_num){
  $query = "DELETE FROM `sales` WHERE `invoice_number` = '$invoice_num'";
  if(mysqli_query($connection,$query)){
    return true;
  }else{
   return false;
 }
}


function getAllSales($connection){
  $query = "SELECT sales.id AS id ,sales.invoice_number AS invoice,customers.customer_name AS customer_name, customers.customer_phone  AS customer_phone, sales.supply_status AS supply_status, sales.amount_paid AS amount_paid, sales.total AS total, sales.sale_date AS sale_date FROM 
  `sales` INNER JOIN `customers` ON sales.customer_id = customers.id ";

  if ($result = mysqli_query($connection,$query)){
   return $result;
 }else{
   trigger_error(mysqli_error($connection));
   return false;
 }
}

function getTotalSales($connection){
  $query = "SELECT SUM(amount_paid) as total_sales FROM sales";
  if($result = mysqli_query($connection, $query)){
    $total_sales = mysqli_fetch_assoc($result)['total_sales'];
    if($total_sales == NULL){
     return 0;
   }else{
     return $total_sales;
   }
 }else{
   trigger_error(mysqli_error($connection));
   return false;
 }
}

function getTodaySales($connection){
 $today = date("Y-m-d");
 $query = "SELECT SUM(total) as total_sales FROM sales WHERE sale_date = '$today'";
 if($result = mysqli_query($connection, $query)){
   $total_sales = mysqli_fetch_assoc($result)['total_sales'];
   if($total_sales == NULL){
     return 0;
   }else{
     return $total_sales;
   }
 }else{
   trigger_error(mysqli_error($connection));
   return false;
 }
}

function getSalesCount($connection){
 $query = "SELECT COUNT(*) as sales_count FROM sales";
 if($result = mysqli_query($connection, $query)){
  $sales_count = mysqli_fetch_assoc($result)['sales_count'];
  if($sales_count == NULL){
   return 0;
 }else{
   return $sales_count;
 }
}else{
 trigger_error(mysqli_error($connection));
 return false;
}
}

function getSalesCountToday($connection){
  $today = date("Y-m-d");
  $query = "SELECT COUNT(*) as sales_count FROM sales WHERE sale_date = '$today'";
  if($result = mysqli_query($connection, $query)){
    $sales_count = mysqli_fetch_assoc($result)['sales_count'];
    if($sales_count == NULL){
     return 0;
   }else{
     return $sales_count;
   }
 }else{
   trigger_error(mysqli_error($connection));
   return false;
 }
}
?>


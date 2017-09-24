<?php

error_reporting("E_ALL|E_STRICT") ;
$connection = include('resources/conection.inc.php');


// $table,$field,$newvalue,$selection_condition = array()

update('stocks','quantity_in_store' , '20' , array('field' => 'description', 'value' =>'jabi')
  ,$connection);
  
   




function update($table,$field,$newvalue,$selection_condition = array(),$connection){
  $selection_condition = (object)$selection_condition;

  echo $query = "UPDATE  $table SET $field = '$newvalue' WHERE $table.$selection_condition->field ='$selection_condition->value' ";

  if (mysqli_query($connection,$query)){
    return true;
  }else{
    trigger_error(mysqli_error($connection));
    return false;
  }
}





?>
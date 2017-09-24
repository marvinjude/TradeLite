<?php

$connection = include('../resources/conection.inc.php');


// the where clause is left optional incase the user wants to delete every row!
function dbRowDelete($table_name, $where_clause='')
{
    // check for optional where clause
    $whereSQL = '';
    if(!empty($where_clause))
    {
        // check to see if the 'where' keyword exists
        if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
        {
            // not found, add keyword
            $whereSQL = " WHERE ".$where_clause;
        } else
        {
            $whereSQL = " ".trim($where_clause);
        }
    }
    // build the query
    $sql = "DELETE FROM ".$table_name.$whereSQL;

    // run and return the query result resource
    return mysqli_query($connection, $sql);
}


// again where clause is left optional
function dbRowUpdate($table_name, $form_data, $where_clause='')
{
    // check for optional where clause
    $whereSQL = '';
    if(!empty($where_clause))
    {
        // check to see if the 'where' keyword exists
        if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
        {
            // not found, add key word
            $whereSQL = " WHERE ".$where_clause;
        } else
        {
            $whereSQL = " ".trim($where_clause);
        }
    }
    // start the actual SQL statement
    $sql = "UPDATE ".$table_name." SET ";

    // loop and build the column /
    $sets = array();
    foreach($form_data as $column => $value)
    {
         $sets[] = "`".$column."` = '".$value."'";
    }
    $sql .= implode(', ', $sets);

    // append the where statement
    $sql .= $whereSQL;

    // run and return the query result
    return mysqli_query($connection,$sql);
}


function dbRowInsert($table_name, $form_data)
{    global $connection;
    // retrieve the keys of the array (column titles)
    $fields = array_keys($form_data);

    // build the query
    $sql = "INSERT INTO ".$table_name."
    (`".implode('`,`', $fields)."`)
    VALUES('".implode("','", $form_data)."')";

    // run and return the query result resource
    return mysqli_query($connection, $sql);
}













//used for getting a single $field from database
function get($table,$field){
	global $connection;
	$data = array();
	$query = "SELECT $field FROM $table";
	if($result = mysqli_query($connection,$query)){
		
		for($i = 0; $i< mysqli_num_rows($result); $i++){
			array_push($data, mysqli_fetch_assoc($result));
		}
		$connection->close;
		return $data;
	} 
}

//get all data data from table
function get_all($table){
	global $connection;
	$all_data = array();
	$query = "SELECT * FROM $table";
	if ($result = mysqli_query($connection,$query)){

		for($i = 0; $i< mysqli_num_rows($result); $i++){
			array_push($all_data, mysqli_fetch_assoc($result));
		}

	}else{
		trigger_error(mysqli_error($connection));
	}
	$connection->close;
	return $all_data;

}

//update a field in the database accept only one select condition 
function update($table,$field,$newvalue,$selection_condition = array()){
	global $connection;
	$selection_condition = (object)$selection_condition;

	echo $query = "UPDATE  '$table' SET '$field' = '$newvalue' WHERE '$table'.
	'$selection_condition->field' ='$selection_condition->value'  ";
	if (mysqli_query($connection,$query)){
		return true;
	}else{
		return false;
	}
}


?>
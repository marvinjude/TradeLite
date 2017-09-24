<?php

$config = include('config.php') ;
$mysqli = new mysqli($config->host , $config->username, $config->password , $config->db);

if(!$mysqli){
    trigger_error("unable_to_connect". mysqli_error($mysqli));
}else{
	return $mysqli;
}

?>
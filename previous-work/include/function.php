<?php 
require 'include/include.php';
function showalldata() 
{
	global $mysqli;
$query = "SELECT * FROM stock";
	
	$result = mysqli_query($mysqli, $query);
	if(!$result) {
		die('QUERY FAILED' .mysqli_error());
	}else{
		echo "";
	}
	while ($row = mysqli_fetch_assoc($result)) {
	# code...
	$costpertorn = $row['costpertorn'];
echo " <option value='$costpertorn'> $costpertorn</option>";	

}
}

function updateTable()
//if(isset($_POST['submit']))
 {
 	global $mysqli;
	//$goodsname = $_POST['goodsname'];
	//$description = $_POST['description'];
	$costpertorn = $_POST['costpertorn'];
	//$id = $_POST['id'];

	$query = "UPDATE stock SET ";
	$query .= "  costpertorn =  '$costpertorn' ,";
	$query = "  WHERE costpertorn =  '$costpertorn' ";

$result = mysqli_query($mysqli, $query);
if(!$mysqli) {
	die("QUERY FAILED " .mysqli_error($mysqli));
}
}
?>
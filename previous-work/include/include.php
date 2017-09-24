<?php 
$mysqli = new mysqli('localhost' , 'root' , '' , 'nigeria');


if(!$mysqli){
	echo "not comected";
}else{
	echo "";
}
/*if(mysqli_connect_errno()) {
	printf('connected failed: %s/n', mysqli_errno());
	exit();
}else{
echo "okay";
}
*/
?>
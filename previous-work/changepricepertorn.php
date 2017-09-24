
<?php 
require 'include/include.php';
require 'header/styles.php';
require 'include/function.php';
/*
if(isset($_POST['goodsname']) &&isset($_POST['description']) &&isset($_POST['costpertorn'])){
$goodsname = $_POST['goodsname'];
$description = $_POST['description'];
$costpertorn = $_POST['costpertorn'];

$query = "UPDATE stock SET newcostpertorn = '$costpertorn' WHERE costpertorn = $costpertorn";
} */


 ?>

<?php 
if(isset($_POST['update'])) {

updateTable();
}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>changeprice per torn</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.js">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-tabdrop">
</head>
<body>
<div class="container">
<form action="" method="POST" class="form-horizontal" role="form">
<br>
<div class="form-group row">
  <label for="goodsname" class="col-2 col-form-label">GOODSNAME</label>
  <div class="col-10">
    <input class="form-control" type="text" value="" name="goodsname" id="" placeholder="pleae fill the goods">
  </div>
</div>

<div class="form-group row">
  <label for="description" class="col-2 col-form-label">DESCRIPTION</label>
  <div class="col-10">
    <input class="form-control" type="text" value=""  name="description" id="" placeholder="pleae fill the description">
  </div>
</div>

<div class="form-group row">
  <label for="cost" class="col-2 col-form-label">COST</label>
  <div class="col-10">
    <input class="form-control" type="text" value="" id="" name="costpertorn" placeholder="pleae fill the newcostpertorn">
  </div>
</div>

<!--this update is done from the id-->

<div class="form-group row">
<label for="invoice" class="col-2 col-form-label">OLD COSTPERTORN</label>
 <div class="col-10">
<select class="form-control" id="" name="costpertorn">

	<!-- option value -->
<?php


	showalldata();
	?>

</select>
</div>
<!--
<div class="form-group row">
  <label for="newcost" class="col-2 col-form-label">NEW COST</label>
  <div class="col-10">
    <input class="form-control" type="text" value="" id="" name="newcostpertorn" placeholder="pleae fill the new cost">
  </div>
</div>
-->
<br>
<input type="submit" class="btn btn-success btn-lg"  value="UPDATE" role="button" name="update">

<input type="button" class="btn btn-primary btn-lg " role="button" value="delete" name="delete">
</form>
</div>
</body>
<?php 
require 'header/styles.php';
 ?>
</html>

	<?php 
	require 'include/include.php';
if(isset($_POST['item']) &&isset($_POST['description']) &&isset($_POST['quantity']) &&isset($_POST['costpertorn'])) {
	$item = $_POST['item'];
	$description = $_POST['description'];
	$quantity = $_POST['quantity'];
	$costpertorn = $_POST['costpertorn'];

$query = "INSERT INTO stock (item , description, quantity, costpertorn) 
	VALUES ('$item' , '$description', '$quantity' , '$costpertorn')";
if (mysqli_query($mysqli, $query)) {
    echo "";
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($mysqli);
}

}
mysqli_close($mysqli);
 ?>

<?php 




 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
<h1 style="text-align: center;">New stock creating form</h1>
<div class="container">

<form action="" method="POST" class="form-horizontal" id="">
<div class="form-group row">
  <label for="ITEM" class="col-2 col-form-label">ITEM</label>
  <div class="col-10">
    <input class="form-control" type="text" value="" name="item" id="" placeholder="pleae fill the item">
  </div>
</div>
<div class="form-group row">
  <label for="description" class="col-2 col-form-label">DESCRIPTION</label>
  <div class="col-10">
    <input class="form-control" type="" value="" name="description" placeholder="please fill the description" id="">
  </div>
</div>
<div class="form-group row">
  <label for="quantity" class="col-2 col-form-label">QUANTITY</label>
  <div class="col-10">
    <input class="form-control" type="text" value="" name="quantity" placeholder="please fill the quantity per torn" id="">
  </div>

</div>
<div class="form-group row">
  <label for="costpertorn" class="col-2 col-form-label">COST PER TORN</label>
  <div class="col-10">
    <input class="form-control" type="text" value="" name="costpertorn" placeholder="please fill the cost per torn" id="">
  </div>
</div>

<input  type="submit"  class="btn btn-primary btn-lg" value="save" role="button" name="save">

<input type="button" class="btn btn-primary btn-lg " role="button" value="delete" name="delete">
</form>
</div>
</body>
</html>
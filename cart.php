<?php

session_start(); // เริ่มต้นทำงาน session

if(isset($_GET["act"]) && $_GET["act"] == "add"){ // ส่วนของการเพิ่มสินค้าในตะกร้า
	if(!isset($_SESSION["LINE"])){
		$_SESSION["LINE"] = 0;
		$_SESSION["PRODUCT_ID"][0] = $_GET["product_id"];
		$_SESSION["QTY"][0] = 0;
		
		header("location:cart.php");
	}
	
	$key = array_search($_GET["product_id"], $_SESSION["PRODUCT_ID"]);
	if((string)$key != ""){
		$_SESSION["QTY"][$key] = $_SESSION["QTY"][$key] + 1;
	}else{
		$_SESSION["LINE"] = $_SESSION["LINE"] + 1;
		$newLine = $_SESSION["LINE"];
		$_SESSION["PRODUCT_ID"][$newLine] = $_GET["product_id"];
		$_SESSION["QTY"][$newLine] = 1;
	}
	header("location:cart.php");
	
	
}elseif(isset($_GET["act"]) && $_GET["act"] == "delete"){ // ส่วนของการลบสินค้าในตะกร้า
	if(isset($_GET["line"]) && isset($_GET["product_id"])){
		unset($_SESSION["PRODUCT_ID"][$_GET["line"]]);
		unset($_SESSION["QTY"][$_GET["line"]]);
		
		header("location:./");
	}
}elseif(isset($_GET["act"]) && $_GET["act"] == "update"){ // ส่วนของการอัพเดทจำนวนสินค้าในตะกร้า
	for($i=0; $i<=$_SESSION["LINE"]; $i++){
		if($_SESSION["PRODUCT_ID"][$i] != ""){
			$_SESSION["QTY"][$i] = $_REQUEST["qty". $i];
		}
	}
	header("location:cart.php");

}elseif(isset($_GET["act"]) && $_GET["act"] == "clear"){ // ส่วนของการเคลีย์ข้อมูล session ทั้งหมด
	session_destroy();
	header("location:cart.php");
}

$qty = 0;
if(!empty($_SESSION["QTY"])){
$qty = array_sum($_SESSION["QTY"]);	
}


// print session ออกมาดู
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>CART</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>
	<ul class="list-unstyled list-inline text-center">
		<li class="list-inline-item"><a href="index.php" class="text-decoration-none font-weight-bold">HOME</a></li>
		<li class="list-inline-item"><a href="cart.php" class="text-decoration-none font-weight-bold">CART (<?php echo $qty;?>)</a></li>
	</ul>
	<div class="container">
	<div class="row">
	<div class="col-12">
	<form action="?act=update" method="POST">
		<table class="table">
	<thead>
	<tr>
		<th colspan="3">CART</th>
	<tr>
	<tr>
		<th>PRODUCT NAME</th>
		<th>QTY</th>
		<th>DELETE</th>
	<tr>
	</thead>
	<tbody>
	<?php
	$product_name = array("1"=>"PRODUCT 1","2"=>"PRODUCT 2", "3"=>"PRODUCT 3");
	$count = 0;
	if(isset($_SESSION["LINE"])){
		for($i=0; $i<= (int)$_SESSION["LINE"]; $i++){
			if(!empty($_SESSION["PRODUCT_ID"][$i])){
			$count++;
	?>
	<tr>
		<td><?php echo $product_name[$_SESSION["PRODUCT_ID"][$i]];?></td>
		<td>
		<input type="number" name="qty<?php echo $i;?>" value="<?php echo $_SESSION["QTY"][$i];?>">
		</td>
		<td><a href="?act=delete&line=<?php echo $i;?>&product_id=<?php echo $_SESSION["PRODUCT_ID"][$i];?>">DELETE</a></td>
		<input type="hidden" name="product_id<?php echo $i;?>" value="<?php echo $_SESSION["PRODUCT_ID"][$i];?>">
	<tr>
	<?php
			}
		} //for($i=0; $i<= (int)$_SESSION["LINE"]; $i++){
	} //if(isset($_SESSION["LINE"])){
	?>
	
	<?php
	if($count == 0){
	?>
	
	<tr>	
		<td colspan="3" align="center">Your shopping cart is empty</td>
	</tr>
	<?php
	}
	?>

	</tbody>
	
	</table>
	<div align="center">
	<button type="submit">UPDATE CART</button> |
	<button type="button" onClick="window.location='?act=clear'">CLEAR CART</button> |
	<button type="button" onClick="window.location='index.php'">CONTINUE SHOPPING</button>
	</div>
	
	
	</form>
	</div>
	</div>
	</div>
</body>

</html>
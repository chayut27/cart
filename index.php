<?php

session_start(); // เริ่มต้นทำงาน session

if(isset($_GET["act"]) && $_GET["act"] == "add"){ // ส่วนของการเพิ่มสินค้าในตะกร้า
	if(!isset($_SESSION["LINE"])){
		$_SESSION["LINE"] = 0;
		$_SESSION["PRODUCT_ID"][0] = $_GET["product_id"];
		$_SESSION["QTY"][0] = 0;
		
		header("location:./");
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
	// header("location:./");
	
	
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
	header("location:./");

}elseif(isset($_GET["act"]) && $_GET["act"] == "clear"){ // ส่วนของการเคลีย์ข้อมูล session ทั้งหมด
	session_destroy();
	header("location:./");
}


// print session ออกมาดู
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>CART</title>
</head>

<body>
	<table width="600" border="1">
	<thead>
	<tr>
		<th>PRODUCT NAME</th>
		<th></th>
	<tr>
	</thead>
	<tbody>
	<tr>
		<td>PRODUCT 1</td>
		<td><a href="?act=add&product_id=1">ADD CART</a></td>
	<tr>
	<tr>
		<td>PRODUCT 2</td>
		<td><a href="?act=add&product_id=2">ADD CART</a></td>
	<tr>
	<tr>
		<td>PRODUCT 3</td>
		<td><a href="?act=add&product_id=3">ADD CART</a></td>
	<tr>
	</tbody>
	
	</table>
	<hr>
	<form action="?act=update" method="POST">
		<table width="600" border="1">
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
		<td colspan="3" align="center">cart empty</td>
	</tr>
	<?php
	}
	?>

	</tbody>
	
	</table>
	<button type="submit">UPDATE CART</button> |
	<button type="button" onClick="window.location='?act=clear'">CLEAR CART</button>
	</form>
	
</body>

</html>
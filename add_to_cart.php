<?php
header("Content-Type: application/json");
require_once "database.php";

$data = json_decode(file_get_contents("php://input"), true);

$userid = $data['userid'];
$productid = $data['productid'];
$qty = $data['quantity'];

$check = "SELECT * FROM cart 
WHERE userid='$userid' 
AND productid='$productid' 
AND status='active'";

$result = $conn->query($check);

if($result->num_rows > 0){

$row = $result->fetch_assoc();
$newQty = $row['quantity'] + $qty;

$conn->query("UPDATE cart SET quantity='$newQty' WHERE cartid='".$row['cartid']."'");

echo json_encode([
"success"=>true,
"message"=>"Quantity Updated"
]);

}else{

$conn->query("INSERT INTO cart(userid,productid,quantity,status)
VALUES('$userid','$productid','$qty','active')");

echo json_encode([
"success"=>true,
"message"=>"Added to cart"
]);

}

$conn->close();
?>
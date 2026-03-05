<?php

header("Content-Type: application/json");
$conn = new mysqli("localhost","root","","ecommerce");

$userid = $_GET['userid'];

$sql = "SELECT 
cart.productid,
cart.quantity,
products.item_name,
products.image1

FROM cart
JOIN products ON cart.productid = products.productid
WHERE cart.userid='$userid'";

$result = $conn->query($sql);

$cart = [];

if($result->num_rows > 0){

while($row = $result->fetch_assoc()){
$cart[] = $row;
}

echo json_encode([
"success"=>true,
"cart"=>$cart
]);

}else{

echo json_encode([
"success"=>false,
"cart"=>[]
]);

}

$conn->close();

?>
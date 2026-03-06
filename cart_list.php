<?php
header("Content-Type: application/json");
require_once "database.php";

if(isset($_GET['userid'])){

$userid = $_GET['userid'];

$sql = "SELECT 
cart.cartid,
cart.quantity,
products.productid,
products.item_name,
products.price,
products.image1

FROM cart

JOIN products ON cart.productid = products.productid

WHERE cart.userid = '$userid' AND cart.status='active'";

$result = $conn->query($sql);

$cart = [];

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
"message"=>"userid required"
]);

}

$conn->close();
?>
<?php
header("Content-Type: application/json");
require_once "database.php";

if(isset($_POST['userid']) && isset($_POST['productid']) && isset($_POST['quantity'])){

$userid = $_POST['userid'];
$productid = $_POST['productid'];
$qty = $_POST['quantity'];

$sql = "INSERT INTO cart (userid,productid,quantity,status)
VALUES ('$userid','$productid','$qty','active')";

if($conn->query($sql)){
    
echo json_encode([
"success"=>true,
"message"=>"Added to cart"
]);

}else{

echo json_encode([
"success"=>false,
"message"=>"Database error"
]);

}

}else{

echo json_encode([
"success"=>false,
"message"=>"Missing parameters"
]);

}

$conn->close();
?>
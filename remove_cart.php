<?php
header("Content-Type: application/json");
require_once "database.php";

$data = json_decode(file_get_contents("php://input"), true);

if(isset($data['cartid'])){

$cartid = $data['cartid'];

$sql = "DELETE FROM cart WHERE cartid='$cartid'";

if($conn->query($sql)){

echo json_encode([
"success"=>true,
"message"=>"Item removed"
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
"message"=>"cartid required"
]);

}

$conn->close();
?>
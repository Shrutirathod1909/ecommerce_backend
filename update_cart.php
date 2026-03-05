<?php
require_once "database.php";

$userid = $_POST['userid'];
$productid = $_POST['productid'];
$qty = $_POST['quantity'];

$sql = "UPDATE cart 
SET quantity='$qty' 
WHERE userid='$userid' AND productid='$productid'";

$conn->query($sql);

echo json_encode(["success"=>true]);
?>
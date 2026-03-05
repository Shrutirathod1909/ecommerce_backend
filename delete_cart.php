<?php
require_once "database.php";

$userid = $_POST['userid'];
$productid = $_POST['productid'];

$sql = "DELETE FROM cart 
WHERE userid='$userid' AND productid='$productid'";

$conn->query($sql);

echo json_encode(["success"=>true]);
?>
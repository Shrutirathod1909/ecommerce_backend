<?php
header("Content-Type: application/json");
require_once "database.php";

$action = $_POST['action'];

switch($action){

// ADD
case "add":

$userid = $_POST['userid'];
$productid = $_POST['productid'];
$quantity = $_POST['quantity'];
$unit_price = $_POST['unit_price'];

$check = mysqli_query($conn,"SELECT * FROM wishlist_log WHERE userid='$userid' AND productid='$productid'");

if(mysqli_num_rows($check)>0){
echo json_encode(["status"=>"exists","message"=>"Already in wishlist"]);
exit();
}

$total = $quantity * $unit_price;

$sql="INSERT INTO wishlist_log(userid,productid,quantity,unit_price,total_price,status,created_on)
VALUES('$userid','$productid','$quantity','$unit_price','$total','Created',NOW())";

if(mysqli_query($conn,$sql)){
echo json_encode(["status"=>"success","message"=>"Added to wishlist"]);
}

break;

// GET WISHLIST
case "get":

$userid = $_POST['userid'];

$sql = mysqli_query($conn,"
SELECT p.productid,p.item_name,p.price,p.image1
FROM wishlist_log w
JOIN products p ON p.productid = w.productid
WHERE w.userid='$userid'
");

$data = [];

while($row=mysqli_fetch_assoc($sql)){
$data[] = $row;
}

echo json_encode([
"status"=>"success",
"data"=>$data
]);

break;

// CHECK WISHLIST
case "check":

$userid = $_POST['userid'];
$productid = $_POST['productid'];

$sql = mysqli_query($conn,"SELECT * FROM wishlist_log WHERE userid='$userid' AND productid='$productid'");

if(mysqli_num_rows($sql) > 0){
echo json_encode(["exists"=>true]);
}else{
echo json_encode(["exists"=>false]);
}

break;



// DELETE PRODUCT
case "delete":

$userid = $_POST['userid'];
$productid = $_POST['productid'];

$sql = mysqli_query($conn,"DELETE FROM wishlist_log WHERE userid='$userid' AND productid='$productid'");

if($sql){
echo json_encode(["status"=>"success","message"=>"Removed from wishlist"]);
}

break;

}
?>
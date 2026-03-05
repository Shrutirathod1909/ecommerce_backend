<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once "database.php";

$category = $_GET['category'];

$sql = "SELECT id, subcategory_name, image 
        FROM subcategories 
        WHERE category='$category' AND active=1
        ORDER BY sort_order ASC";

$result = mysqli_query($conn,$sql);

$data = [];

while($row = mysqli_fetch_assoc($result)){

$data[] = [
"id"=>$row['id'],
"title"=>$row['subcategory_name'],
"image"=>$row['image']
];

}

echo json_encode([
"status"=>true,
"data"=>$data
]);

?>
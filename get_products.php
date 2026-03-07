<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once "database.php";

$category = $_GET['category'] ?? "";
$subcategory = $_GET['subcategory'] ?? "";

$sql = "SELECT 
        productid AS id,
        item_name AS name,
        price,
        image1 AS image,
        category,
        subcategory
        FROM products";

if($category != ""){
    $sql .= " WHERE category='$category'";
}

if($subcategory != ""){
    $sql .= ($category != "" ? " AND " : " WHERE ");
    $sql .= "subcategory='$subcategory'";
}

$result = mysqli_query($conn,$sql);

$data = [];

while($row = mysqli_fetch_assoc($result)){
    $data[] = [
        "id" => $row['id'],
        "name" => $row['name'],
        "price" => $row['price'],
        "image" => $row['image'],
        "category" => $row['category'],
        "subcategory" => $row['subcategory']
    ];
}

echo json_encode([
    "status" => true,
    "data" => $data
]);

?>
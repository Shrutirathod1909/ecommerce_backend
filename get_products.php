 <!-- <?php
header("Content-Type: application/json");
require_once "database.php";

$result = $conn->query("SELECT productid, item_name, image1 FROM products WHERE hide='N'");

if (!$result) {
    echo json_encode(["status" => "error", "message" => $conn->error]);
    exit;
}

$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode([
    "status" => "success",
    "products" => $products
]);

$conn->close();
?>  -->
<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once "database.php";

$subcategory = $_GET['subcategory'] ?? ""; // if not provided

if($subcategory != ""){
    $sql = "SELECT 
            productid AS id,
            item_name AS name,
            price,
            image1 AS image
            FROM products
            WHERE subcategory='$subcategory'";
}else{
    // 🔥 get all products
    $sql = "SELECT 
            productid AS id,
            item_name AS name,
            price,
            image1 AS image
            FROM products";
}

$result = mysqli_query($conn,$sql);

$data = [];

while($row = mysqli_fetch_assoc($result)){
    $data[] = [
        "id" => $row['id'],
        "name" => $row['name'],
        "price" => $row['price'],
        "image" => $row['image']
    ];
}

echo json_encode([
    "status" => true,
    "data" => $data
]);

?>

<?php
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
?>
<?php
header("Content-Type: application/json");
require_once "database.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Product ID required"
    ]);
    exit;
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM products WHERE productid = ? AND hide='N'");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Product not found"
    ]);
    exit;
}

$product = $result->fetch_assoc();

echo json_encode([
    "status" => "success",
    "product" => $product
], JSON_UNESCAPED_UNICODE);

$stmt->close();
$conn->close();
?>
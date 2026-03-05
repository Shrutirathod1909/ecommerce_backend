<?php
require_once "config/database.php";
header('Content-Type: application/json');

if (!isset($_POST['user_id']) || !isset($_POST['product_id'])) {
    echo json_encode(["error" => true, "message" => "Required fields missing"]);
    exit;
}

$user_id = intval($_POST['user_id']);
$product_id = intval($_POST['product_id']);

$check = $conn->prepare("SELECT id FROM wishlist WHERE user_id=? AND product_id=?");
$check->bind_param("ii", $user_id, $product_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["error" => true, "message" => "Already in wishlist"]);
    exit;
}

$insert = $conn->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?,?)");
$insert->bind_param("ii", $user_id, $product_id);
$insert->execute();

echo json_encode(["error" => false, "message" => "Added to wishlist"]);
?>
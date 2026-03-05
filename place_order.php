<?php
require_once "config/database.php";
header('Content-Type: application/json');

if (!isset($_POST['user_id'])) {
    echo json_encode(["error" => true, "message" => "User ID required"]);
    exit;
}

$user_id = intval($_POST['user_id']);

/* Get cart items */
$cartQuery = $conn->prepare("
    SELECT c.product_id, c.quantity, p.price 
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id=?
");
$cartQuery->bind_param("i", $user_id);
$cartQuery->execute();
$cartItems = $cartQuery->get_result();

if ($cartItems->num_rows == 0) {
    echo json_encode(["error" => true, "message" => "Cart is empty"]);
    exit;
}

$total = 0;
$items = [];

while ($row = $cartItems->fetch_assoc()) {
    $total += $row['price'] * $row['quantity'];
    $items[] = $row;
}

/* Insert order */
$orderStmt = $conn->prepare("INSERT INTO orders (user_id, total_amount) VALUES (?,?)");
$orderStmt->bind_param("id", $user_id, $total);
$orderStmt->execute();
$order_id = $conn->insert_id;

/* Insert order items */
foreach ($items as $item) {
    $itemStmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?,?,?,?)");
    $itemStmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
    $itemStmt->execute();
}

/* Clear cart */
$conn->query("DELETE FROM cart WHERE user_id=$user_id");

echo json_encode([
    "error" => false,
    "message" => "Order placed successfully",
    "order_id" => $order_id
]);
?>
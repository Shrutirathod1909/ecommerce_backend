<?php
header("Content-Type: application/json");
require_once "database.php";

$data = json_decode(file_get_contents("php://input"), true);

$phone = $data['phone'] ?? '';

if (empty($phone)) {
    echo json_encode(["status"=>"error","message"=>"Mobile required"]);
    exit;
}

// Check user exists
$stmt = $conn->prepare("SELECT id FROM users WHERE phone=?");
$stmt->bind_param("s", $phone);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo json_encode(["status"=>"error","message"=>"Mobile not registered"]);
    exit;
}

// Generate OTP
$otp = rand(1000,9999);

// Store OTP (you must have otp column in users table)
$update = $conn->prepare("UPDATE users SET otp=? WHERE phone=?");
$update->bind_param("ss", $otp,$phone);
$update->execute();

// For testing only (real app madhe SMS send kara)
echo json_encode([
    "status"=>"success",
    "message"=>"OTP Sent",
    "otp"=>$otp
]);

$conn->close();
?>
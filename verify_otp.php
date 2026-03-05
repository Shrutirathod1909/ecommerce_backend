<?php
header("Content-Type: application/json");
require_once "database.php";

$data = json_decode(file_get_contents("php://input"), true);

$phone = $data['phone'] ?? '';
$otp   = $data['otp'] ?? '';

$stmt = $conn->prepare("SELECT id FROM users WHERE phone=? AND otp=?");
$stmt->bind_param("ss",$phone,$otp);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["status"=>"success","message"=>"OTP Verified"]);
} else {
    echo json_encode(["status"=>"error","message"=>"Invalid OTP"]);
}

$conn->close();
?>
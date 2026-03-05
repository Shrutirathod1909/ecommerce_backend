<?php
header("Content-Type: application/json");
require_once "database.php";

$data = json_decode(file_get_contents("php://input"), true);

$phone    = $data['phone'] ?? '';
$password = $data['password'] ?? '';

$hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE users SET password=?, otp=NULL WHERE phone=?");
$stmt->bind_param("ss",$hashed,$phone);

if($stmt->execute()){
    echo json_encode(["status"=>"success","message"=>"Password Reset Successful"]);
}else{
    echo json_encode(["status"=>"error","message"=>"Reset Failed"]);
}

$conn->close();
?>
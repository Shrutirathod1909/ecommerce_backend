<?php
header("Content-Type: application/json");
require_once "database.php";

$fullname = $_POST['fullname'] ?? '';
$email    = $_POST['email'] ?? '';
$phone    = $_POST['phone'] ?? '';
$password = $_POST['password'] ?? '';

if(empty($fullname) || empty($email) || empty($phone) || empty($password)){
    echo json_encode([
        "status"=>"error",
        "message"=>"All fields are required"
    ]);
    exit;
}

# check if email exists
$check = $conn->prepare("SELECT id FROM users WHERE email=?");
$check->bind_param("s",$email);
$check->execute();
$check->store_result();

if($check->num_rows > 0){
    echo json_encode([
        "status"=>"error",
        "message"=>"Email already registered"
    ]);
    exit;
}

# hash password
$hashedPassword = password_hash($password,PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users(fullname,email,phone,password) VALUES(?,?,?,?)");
$stmt->bind_param("ssss",$fullname,$email,$phone,$hashedPassword);

if($stmt->execute()){
    echo json_encode([
        "status"=>"success",
        "message"=>"Registration Successful"
    ]);
}else{
    echo json_encode([
        "status"=>"error",
        "message"=>"Registration Failed"
    ]);
}

$stmt->close();
$conn->close();
?>
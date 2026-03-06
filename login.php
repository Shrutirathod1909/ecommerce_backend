<?php
header("Content-Type: application/json");
require_once "database.php";

// Get POST data
$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if(empty($email) || empty($password)){
    echo json_encode([
        "status"=>"error",
        "message"=>"Email and Password required"
    ]);
    exit;
}

// Get user
$stmt = $conn->prepare("SELECT id,fullname,email,phone,password FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $user = $result->fetch_assoc();

    if(password_verify($password, $user['password'])){
        echo json_encode([
            "status"=>"success",
            "message"=>"Login Successful",
            "user"=>[
                "userid"=>$user['id'],        // note: key matches Flutter code
                "fullname"=>$user['fullname'],
                "email"=>$user['email'],
                "phone"=>$user['phone']
            ]
        ]);
    } else {
        echo json_encode([
            "status"=>"error",
            "message"=>"Invalid Password"
        ]);
    }

} else {
    echo json_encode([
        "status"=>"error",
        "message"=>"Email not registered"
    ]);
}

$conn->close();
?>
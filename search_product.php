<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once "database.php";

if(isset($_FILES['image'])){

    $image = $_FILES['image']['name'];
    $tmp   = $_FILES['image']['tmp_name'];

    $path = "uploads/".$image;

    move_uploaded_file($tmp,$path);

    // Example product search
    $query = mysqli_query($conn,"SELECT * FROM products");

    $products = [];

    while($row = mysqli_fetch_assoc($query)){
        $products[] = $row;
    }

    echo json_encode([
        "status"=>"success",
        "image"=>$path,
        "products"=>$products
    ]);

}else{

    echo json_encode([
        "status"=>"error",
        "message"=>"Image not found"
    ]);

}
?>
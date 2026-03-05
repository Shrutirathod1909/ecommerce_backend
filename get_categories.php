<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once "database.php";

$sql = "SELECT id, category_name, image 
        FROM categories 
        WHERE active = 1 
        ORDER BY sort_order ASC";

$result = mysqli_query($conn, $sql);

$categories = [];

if($result){
    while($row = mysqli_fetch_assoc($result)){

        $categories[] = [
            "id" => $row["id"],
            "category_name" => $row["category_name"],
            "image" => $row["image"]
        ];
    }

    echo json_encode([
        "status" => true,
        "data" => $categories
    ]);

}else{

    echo json_encode([
        "status" => false,
        "message" => "Failed to fetch categories"
    ]);
}

?>
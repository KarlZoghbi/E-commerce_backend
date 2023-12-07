<?php
include("./connection.php");
include("./jwt.php");

$decoded = decodeJWT();

if ($decoded->user_type_id == 1) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

   
    $seller_id = $decoded->user_id;

    $sqli = $mysqli->prepare("INSERT INTO products (name, description, price, seller_id) VALUES (?, ?, ?, ?)");
    $sqli->bind_param("ssdi", $name, $description, $price, $seller_id);

    if ($sqli->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => $sqli->error]);
    }
} else {
    http_response_code(403); // Forbidden
    echo json_encode(['error' => 'Unauthorized access']);
    exit();
}
?>

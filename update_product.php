<?php
include("../connection.php");
include("../jwt.php");

$decoded = decodeJWT();

if ($decoded->user_type_id == 1) {
    $id_product = $_POST['id_product'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $sqli_check_seller = $mysqli->prepare("SELECT seller_id FROM products WHERE product_id = ?");
    $sqli_check_seller->bind_param("i", $id_product);
    $sqli_check_seller->execute();
    $sqli_check_seller->bind_result($seller_id);
    $sqli_check_seller->fetch();
    $sqli_check_seller->close();

    if ($decoded->user_id == $seller_id) {
        $sqli = $mysqli->prepare("UPDATE products SET name = ?, description = ?, price = ? WHERE product_id = ?");
        $sqli->bind_param("ssdi", $name, $description, $price, $id_product);

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
} else {
    http_response_code(403); // Forbidden
    echo json_encode(['error' => 'Unauthorized access']);
    exit();
}
?>

<?php
include("connection.php");

if (isset($_POST['email'], $_POST['password'], $_POST['user_name'], $_POST['first_name'], $_POST['last_name'], $_POST['age'], $_POST['gender'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_name = $_POST['user_name'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Set the user_type_id to '1' for a regular user
    $user_type_id = 1;

    $query = $mysqli->prepare('INSERT INTO users (email, password, user_name, first_name, last_name, age, gender, user_type_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');

    if (!$query) {
        die("Error in query preparation: " . $mysqli->error);
    }

    $query->bind_param('sssssisi', $email, $hashed_password, $user_name, $first_name, $last_name, $age, $gender, $user_type_id);
    $query->execute();

    if ($query->error) {
        die("Error in query execution: " . $query->error);
    }

    $response = ["status" => "true"];
    echo json_encode($response);

    $query->close();
} else {
    $response = ["status" => "false", "error" => "Missing required data"];
    echo json_encode($response);
}
?>

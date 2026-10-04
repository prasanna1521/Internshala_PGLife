<?php
session_start();

include("db.php");

if (!isset($_SESSION['user_id'])) {
    echo "login_required";
    exit();
}

$user_id = $_SESSION['user_id'];
$property_id = $_POST['property_id'];

$check_query = "SELECT * FROM interested_users
                WHERE user_id = $user_id
                AND property_id = $property_id";

$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) > 0) {

    $delete_query = "DELETE FROM interested_users
                     WHERE user_id = $user_id
                     AND property_id = $property_id";

    mysqli_query($conn, $delete_query);

    echo "removed";

} else {

    $insert_query = "INSERT INTO interested_users (user_id, property_id)
                     VALUES ($user_id, $property_id)";

    mysqli_query($conn, $insert_query);

    echo "added";
}
?>
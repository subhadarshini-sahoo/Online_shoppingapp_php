<!-- ecommerce_platform/add_to_cart.php -->
<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$product_id = (int)$_POST['product_id'];
$user_id = $_SESSION['user_id'];

// Check if already in cart
$result = $conn->query("SELECT * FROM cart WHERE user_id=$user_id AND product_id=$product_id");
if ($result->num_rows > 0) {
    $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE user_id=$user_id AND product_id=$product_id");
} else {
    $conn->query("INSERT INTO cart (user_id, product_id) VALUES ($user_id, $product_id)");
}

header("Location: cart.php");
?>
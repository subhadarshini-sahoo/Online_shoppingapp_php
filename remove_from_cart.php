<!-- ecommerce_platform/remove_from_cart.php -->
<?php
session_start();
require 'db.php';

// Must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$cart_id = (int)$_GET['id']; // Cart item ID to remove

// Security: Only allow removal of own cart items
$stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $cart_id, $user_id);

if ($stmt->execute()) {
    // Optional: Show success message via session
    $_SESSION['cart_message'] = "Item removed from cart!";
} else {
    $_SESSION['cart_message'] = "Failed to remove item.";
}

$stmt->close();
header("Location: cart.php");
exit;
?>
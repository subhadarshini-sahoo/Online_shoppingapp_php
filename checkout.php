<!-- ecommerce_platform/checkout.php -->
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - ShopEase</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">ShopEase</div>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="cart.php">Cart</a>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="form-container">
            <h2>Checkout Complete!</h2>
            <p style="text-align:center; font-size:1.1rem; line-height:1.6;">
                Thank you for your purchase!<br>
                Your order has been processed successfully.
            </p>
            <div style="text-align:center; margin-top:2rem;">
                <a href="index.php" class="btn btn-primary">Continue Shopping</a>
            </div>
        </div>
    </div>
</body>
</html>
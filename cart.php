<!-- ecommerce_platform/cart.php -->
<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$cart_items = $conn->query("
    SELECT c.id AS cart_id, c.quantity, p.id AS product_id, p.name, p.price, p.image 
    FROM cart c 
    JOIN products p ON c.product_id = p.id 
    WHERE c.user_id = $user_id
")->fetch_all(MYSQLI_ASSOC);

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - ShopEase</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">ShopEase</div>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="logout.php">Logout</a>
            </div>
        </nav>
    </header>

    <div class="container">
        <h1 style="color:#0277bd; text-align:center; margin:2rem 0;">Your Cart</h1>

        <!-- Success/Error Message -->
        <?php if (isset($_SESSION['cart_message'])): ?>
            <div style="background:#e8f5e9; color:#2e7d32; padding:1rem; border-radius:12px; text-align:center; margin:1rem 0; font-weight:500;">
                <?php echo $_SESSION['cart_message']; unset($_SESSION['cart_message']); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($cart_items)): ?>
            <p style="text-align:center; font-size:1.2rem; color:#666;">
                Your cart is empty. <a href="index.php" style="color:#00f2fe;">Shop now</a>
            </p>
        <?php else: ?>
            <?php foreach ($cart_items as $item): 
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
                <div class="cart-item">
                    <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                    <div style="flex-grow:1;">
                        <h3><?php echo $item['name']; ?></h3>
                        <p style="color:#555;">
                            $<?php echo number_format($item['price'], 2); ?> × <?php echo $item['quantity']; ?> 
                            = <strong>$<?php echo number_format($subtotal, 2); ?></strong>
                        </p>
                    </div>
                    <!-- Remove Button -->
                    <a href="remove_from_cart.php?id=<?php echo $item['cart_id']; ?>" 
                       class="btn" 
                       style="background:#ff5252; color:white; padding:0.5rem 1rem; font-size:0.9rem;"
                       onclick="return confirm('Remove this item?')">
                       Remove
                    </a>
                </div>
            <?php endforeach; ?>

            <div class="cart-total">
                Total: <span style="color:#ff6f00; font-size:1.6rem;">$<?php echo number_format($total, 2); ?></span>
            </div>

            <div style="text-align:center; margin:2rem 0;">
                <a href="checkout.php" class="btn btn-primary" style="font-size:1.1rem; padding:1rem 2.5rem;">
                    Proceed to Checkout
                </a>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        &copy; 2025 ShopEase. All rights reserved.
    </footer>
</body>
</html>
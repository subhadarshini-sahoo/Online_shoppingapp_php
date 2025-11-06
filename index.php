<!-- ecommerce_platform/index.php -->
<?php
session_start();
require 'db.php';

$products = $conn->query("SELECT * FROM products")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopEase - Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">ShopEase</div>
            <div class="nav-links">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    <a href="cart.php">Cart</a>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a href="register.php">Register</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <div class="container">
        <h1 style="text-align:center; color:#0277bd; margin:2rem 0;">Featured Products</h1>
        <div class="products">
            <?php foreach ($products as $p): ?>
                <div class="product-card">
                    <img src="<?php echo $p['image']; ?>" alt="<?php echo $p['name']; ?>">
                    <div class="product-info">
                        <h3><?php echo $p['name']; ?></h3>
                        <div class="price">$<?php echo number_format($p['price'], 2); ?></div>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <form action="add_to_cart.php" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
                                <button type="submit" class="btn btn-primary">Add to Cart</button>
                            </form>
                        <?php else: ?>
                            <a href="login.php" class="btn btn-primary">Login to Buy</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer>
        &copy; 2025 ShopEase. All rights reserved.
    </footer>
</body>
</html>
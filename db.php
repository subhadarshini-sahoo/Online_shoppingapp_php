<!-- ecommerce_platform/db.php -->
<?php
$host = 'localhost';
$dbname = 'ecommerce_db';
$username = 'root';
$password = '';

try {
    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $conn->set_charset("utf8");

    // Create tables
    $conn->multi_query("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            image VARCHAR(255) NOT NULL
        );

        CREATE TABLE IF NOT EXISTS cart (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            product_id INT,
            quantity INT DEFAULT 1,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
        );
    ");

    // Clear any pending results
    while ($conn->next_result()) {;}

    // === INSERT PRODUCTS ONLY ONCE ===
    $result = $conn->query("SELECT COUNT(*) as count FROM products");
    $row = $result->fetch_assoc();

    if ($row['count'] == 0) {
        // Only insert if products table is empty
        $conn->query("
            INSERT INTO products (name, price, image) VALUES 
            ('Gaming Laptop', 1299.99, 'images/laptop.jpg'),
            ('Smartphone Pro', 999.99, 'images/phone.jpg'),
            ('Wireless Headphones', 199.99, 'images/headphone.jpg'),
            ('TWS Earbuds', 79.99, 'images/earbuds.jpg'),
            ('RGB Gaming Keyboard', 89.99, 'images/keyboard.jpg'),
            ('Ergonomic Mouse', 49.99, 'images/moush.jpg'),
            ('Smart Watch', 249.99, 'images/watch.jpg')
        ");
        error_log("7 products inserted successfully.");
    }

} catch (Exception $e) {
    die("Database Error: " . $e->getMessage());
}
?>
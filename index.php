<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php
$page_title = "Dashboard";
require_once "db.php";

$productCount = 0;
$totalStock = 0;
$lowStockCount = 0;
$totalValue = 0;

$countResult = $conn->query("SELECT COUNT(*) AS total_products, COALESCE(SUM(quantity),0) AS total_stock, COALESCE(SUM(quantity * buying_price),0) AS total_value FROM products");
if ($countResult && $row = $countResult->fetch_assoc()) {
    $productCount = (int)$row['total_products'];
    $totalStock = (int)$row['total_stock'];
    $totalValue = (float)$row['total_value'];
}

$lowResult = $conn->query("SELECT COUNT(*) AS low_count FROM products WHERE quantity <= 5");
if ($lowResult && $row = $lowResult->fetch_assoc()) {
    $lowStockCount = (int)$row['low_count'];
}

require_once "header.php";
?>

<section class="hero-card">
    <div>
        <h2>Welcome!</h2>
        <p>This system helps you add, view, update, delete, and search products in your mini mart inventory.</p>
    </div>
    <a class="btn primary" href="add_product.php">Add New Product</a>
</section>

<section class="stats-grid">
    <div class="stat-card">
        <h3>Total Products</h3>
        <p><?php echo $productCount; ?></p>
    </div>
    <div class="stat-card">
        <h3>Total Stock Units</h3>
        <p><?php echo $totalStock; ?></p>
    </div>
    <div class="stat-card warning">
        <h3>Low Stock Items</h3>
        <p><?php echo $lowStockCount; ?></p>
    </div>
    <div class="stat-card success">
        <h3>Stock Cost Value</h3>
        <p>Rs. <?php echo number_format($totalValue, 2); ?></p>
    </div>
</section>

<section class="grid-two">
    <div class="panel">
        <h3>What this project includes</h3>
        <ul>
            <li>Product registration form</li>
            <li>JavaScript form validation</li>
            <li>PHP server-side processing</li>
            <li>MySQL database with CRUD operations</li>
            <li>Search and low-stock monitoring</li>
        </ul>
    </div>
    <div class="panel">
        <h3>Quick actions</h3>
        <div class="action-list">
            <a class="btn" href="view_products.php">See Product Table</a>
            <a class="btn" href="low_stock.php">Check Low Stock</a>
            <a class="btn" href="database.sql">Open SQL File</a>
        </div>
    </div>
</section>

<?php require_once "footer.php"; ?>
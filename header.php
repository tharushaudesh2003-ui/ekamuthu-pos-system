<?php if (!isset($page_title)) { $page_title = "Ekamuthu Inventory"; } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header class="topbar">
            <div>
                <h1>Ekamuthu Mini Mart Inventory System</h1>
                <p class="subtitle">Simple PHP + MySQL stock management project for a first-year student</p>
            </div>
            <nav class="nav-links">
                <a href="index.php">Dashboard</a>
                <a href="add_product.php">Add Product</a>
                <a href="view_products.php">View Products</a>
                <a href="low_stock.php">Low Stock</a>
            </nav>
        </header>
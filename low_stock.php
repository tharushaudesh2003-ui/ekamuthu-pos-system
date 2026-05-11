<?php
$page_title = "Low Stock";
require_once "db.php";

$result = $conn->query("SELECT * FROM products WHERE quantity <= 5 ORDER BY quantity ASC, id DESC");
$products = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

require_once "header.php";
?>

<section class="panel">
    <div class="section-head">
        <div>
            <h2>Low Stock Products</h2>
            <p class="muted">These products need to be restocked soon.</p>
        </div>
        <a class="btn primary" href="add_product.php">Add Product</a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Barcode</th>
                    <th>Qty</th>
                    <th>Sell Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($products) > 0): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($product['category']); ?></td>
                            <td><?php echo htmlspecialchars($product['barcode']); ?></td>
                            <td><?php echo $product['quantity']; ?></td>
                            <td>Rs. <?php echo number_format($product['selling_price'], 2); ?></td>
                            <td><a class="btn small" href="edit_product.php?id=<?php echo $product['id']; ?>">Update Stock</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="empty-state">No low-stock products right now.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php require_once "footer.php"; ?>
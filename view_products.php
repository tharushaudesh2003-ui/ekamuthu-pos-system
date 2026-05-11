<?php
$page_title = "View Products";
require_once "db.php";

$search = trim($_GET['search'] ?? '');
$products = [];

if ($search !== '') {
    $sql = "SELECT * FROM products
            WHERE product_name LIKE CONCAT('%', ?, '%')
               OR category LIKE CONCAT('%', ?, '%')
               OR barcode LIKE CONCAT('%', ?, '%')
            ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $search, $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM products ORDER BY id DESC");
}

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
            <h2>All Products</h2>
            <p class="muted">Search, review, edit, or delete stored inventory items.</p>
        </div>
        <form method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search by name, category, or barcode" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn primary">Search</button>
            <a href="view_products.php" class="btn secondary">Reset</a>
        </form>
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
                    <th>Buy Price</th>
                    <th>Sell Price</th>
                    <th>Expiry</th>
                    <th>Status</th>
                    <th>Actions</th>
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
                            <td>Rs. <?php echo number_format($product['buying_price'], 2); ?></td>
                            <td>Rs. <?php echo number_format($product['selling_price'], 2); ?></td>
                            <td><?php echo $product['expiry_date'] ? htmlspecialchars($product['expiry_date']) : '-'; ?></td>
                            <td>
                                <?php if ($product['quantity'] <= 5): ?>
                                    <span class="badge danger">Low Stock</span>
                                <?php else: ?>
                                    <span class="badge success">OK</span>
                                <?php endif; ?>
                            </td>
                            <td class="actions">
                                <a class="btn small" href="edit_product.php?id=<?php echo $product['id']; ?>">Edit</a>
                                <a class="btn small danger-btn" href="delete_product.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="empty-state">No products found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php require_once "footer.php"; ?>
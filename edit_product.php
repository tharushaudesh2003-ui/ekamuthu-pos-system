<?php
$page_title = "Edit Product";
require_once "db.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$message = "";
$messageType = "";

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    die("Product not found.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $product_name = trim($_POST["product_name"] ?? "");
    $category = trim($_POST["category"] ?? "");
    $barcode = trim($_POST["barcode"] ?? "");
    $quantity = trim($_POST["quantity"] ?? "");
    $buying_price = trim($_POST["buying_price"] ?? "");
    $selling_price = trim($_POST["selling_price"] ?? "");
    $expiry_date = trim($_POST["expiry_date"] ?? "");

    if ($product_name === "" || $category === "" || $barcode === "" || $quantity === "" || $buying_price === "" || $selling_price === "") {
        $message = "Please fill in all required fields.";
        $messageType = "error";
    } elseif (!is_numeric($quantity) || !is_numeric($buying_price) || !is_numeric($selling_price)) {
        $message = "Quantity and prices must be numeric values.";
        $messageType = "error";
    } else {
        if ($expiry_date === "") {
            $expiry_date = null;
        }

        $sql = "UPDATE products
                SET product_name = ?, category = ?, barcode = ?, quantity = ?, buying_price = ?, selling_price = ?, expiry_date = ?
                WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sssiddsi",
            $product_name,
            $category,
            $barcode,
            $quantity,
            $buying_price,
            $selling_price,
            $expiry_date,
            $id
        );

        if ($stmt->execute()) {
            header("Location: view_products.php");
            exit();
        } else {
            $message = "Error updating product: " . $stmt->error;
            $messageType = "error";
        }
        $stmt->close();
    }

    $product = [
        'id' => $id,
        'product_name' => $product_name,
        'category' => $category,
        'barcode' => $barcode,
        'quantity' => $quantity,
        'buying_price' => $buying_price,
        'selling_price' => $selling_price,
        'expiry_date' => $expiry_date
    ];
}

require_once "header.php";
?>

<section class="panel form-panel">
    <h2>Edit Product</h2>
    <p class="muted">Update the selected product and save your changes.</p>

    <?php if ($message !== ""): ?>
        <div class="alert <?php echo $messageType; ?>"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST" id="productForm" class="product-form" novalidate>
        <div class="form-row">
            <div class="form-group">
                <label for="product_name">Product Name *</label>
                <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>">
            </div>
            <div class="form-group">
                <label for="category">Category *</label>
                <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($product['category']); ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="barcode">Barcode *</label>
                <input type="text" id="barcode" name="barcode" value="<?php echo htmlspecialchars($product['barcode']); ?>">
            </div>
            <div class="form-group">
                <label for="quantity">Quantity *</label>
                <input type="number" id="quantity" name="quantity" min="0" value="<?php echo htmlspecialchars($product['quantity']); ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="buying_price">Buying Price (Rs.) *</label>
                <input type="number" step="0.01" id="buying_price" name="buying_price" min="0" value="<?php echo htmlspecialchars($product['buying_price']); ?>">
            </div>
            <div class="form-group">
                <label for="selling_price">Selling Price (Rs.) *</label>
                <input type="number" step="0.01" id="selling_price" name="selling_price" min="0" value="<?php echo htmlspecialchars($product['selling_price']); ?>">
            </div>
        </div>

        <div class="form-row single">
            <div class="form-group">
                <label for="expiry_date">Expiry Date (optional)</label>
                <input type="date" id="expiry_date" name="expiry_date" value="<?php echo htmlspecialchars($product['expiry_date']); ?>">
            </div>
        </div>

        <div id="clientErrors" class="alert error hidden"></div>

        <div class="form-actions">
            <button type="submit" class="btn primary">Update Product</button>
            <a href="view_products.php" class="btn secondary">Cancel</a>
        </div>
    </form>
</section>

<?php require_once "footer.php"; ?>
<?php

$page_title = "Add Product";
require_once "db.php";

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Get form values safely
    $product_name  = trim($_POST["product_name"] ?? "");
    $category      = trim($_POST["category"] ?? "");
    $barcode       = trim($_POST["barcode"] ?? "");
    $quantity      = trim($_POST["quantity"] ?? "");
    $buying_price  = trim($_POST["buying_price"] ?? "");
    $selling_price = trim($_POST["selling_price"] ?? "");
    $expiry_date   = trim($_POST["expiry_date"] ?? "");

    // Validation
    if (
        $product_name === "" ||
        $category === "" ||
        $barcode === "" ||
        $quantity === "" ||
        $buying_price === "" ||
        $selling_price === ""
    ) {

        $message = "Please fill in all required fields.";
        $messageType = "error";

    } elseif (
        !is_numeric($quantity) ||
        !is_numeric($buying_price) ||
        !is_numeric($selling_price)
    ) {

        $message = "Quantity and price must be numeric values.";
        $messageType = "error";

    } elseif (
        (int)$quantity < 0 ||
        (float)$buying_price < 0 ||
        (float)$selling_price < 0
    ) {

        $message = "Negative values are not allowed.";
        $messageType = "error";

    } else {

        // Empty expiry date => NULL
        if ($expiry_date === "") {
            $expiry_date = null;
        }

        $sql = "INSERT INTO products
                (product_name, category, barcode, quantity, buying_price, selling_price, expiry_date)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "sssidds",
            $product_name,
            $category,
            $barcode,
            $quantity,
            $buying_price,
            $selling_price,
            $expiry_date
        );

        if ($stmt->execute()) {

            $message = "Product added successfully!";
            $messageType = "success";

            // Clear form after success
            $_POST = [];

        } else {

            $message = "Error adding product: " . $stmt->error;
            $messageType = "error";
        }

        $stmt->close();
    }
}

require_once "header.php";
?>

<section class="panel form-panel">

    <h2>Add New Product</h2>

    <?php if ($message !== ""): ?>
        <div class="alert <?php echo $messageType; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="POST" id="productForm" class="product-form" novalidate>

        <div class="form-row">

            <div class="form-group">
                <label for="product_name">Product Name *</label>
                <input
                    type="text"
                    id="product_name"
                    name="product_name"
                    value="<?php echo htmlspecialchars($_POST["product_name"] ?? ""); ?>">
            </div>

            <div class="form-group">
                <label for="category">Category *</label>
                <input
                    type="text"
                    id="category"
                    name="category"
                    value="<?php echo htmlspecialchars($_POST["category"] ?? ""); ?>">
            </div>

        </div>

        <div class="form-row">

            <div class="form-group">
                <label for="barcode">Barcode *</label>
                <input
                    type="text"
                    id="barcode"
                    name="barcode"
                    value="<?php echo htmlspecialchars($_POST["barcode"] ?? ""); ?>">
            </div>

            <div class="form-group">
                <label for="quantity">Quantity *</label>
                <input
                    type="number"
                    id="quantity"
                    name="quantity"
                    min="0"
                    value="<?php echo htmlspecialchars($_POST["quantity"] ?? ""); ?>">
            </div>

        </div>

        <div class="form-row">

            <div class="form-group">
                <label for="buying_price">Buying Price (Rs.) *</label>
                <input
                    type="number"
                    step="0.01"
                    id="buying_price"
                    name="buying_price"
                    min="0"
                    value="<?php echo htmlspecialchars($_POST["buying_price"] ?? ""); ?>">
            </div>

            <div class="form-group">
                <label for="selling_price">Selling Price (Rs.) *</label>
                <input
                    type="number"
                    step="0.01"
                    id="selling_price"
                    name="selling_price"
                    min="0"
                    value="<?php echo htmlspecialchars($_POST["selling_price"] ?? ""); ?>">
            </div>

        </div>

        <div class="form-row single">

            <div class="form-group">
                <label for="expiry_date">Expiry Date</label>
                <input
                    type="date"
                    id="expiry_date"
                    name="expiry_date"
                    value="<?php echo htmlspecialchars($_POST["expiry_date"] ?? ""); ?>">
            </div>

        </div>

        <div id="clientErrors" class="alert error hidden"></div>

        <div class="form-actions">
            <button type="submit" class="btn primary">Save Product</button>
            <button type="reset" class="btn secondary">Clear Form</button>
        </div>

    </form>

</section>

<?php require_once "footer.php"; ?>
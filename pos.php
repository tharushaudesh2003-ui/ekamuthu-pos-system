<?php
$page_title = "POS System";
require_once "header.php";
>?

<section class ="pos-page">
    <div class="pos-left">
        <div class="card search-card">
            <h2>Point Of Sale</h2>

            <div class="search-box">
                <input type="text" id="productSearch" placeholder="Search product or barcode">
                <button class="btn primary">Add Product</button>
            </div>
        </div>

        <div class="card cart-card">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Action</th>                    
                    </tr>
                </thead>

                <tbody id="cartBody">
                    <tr>
                        <td>Anchor Milk Powder</td>
                        <td>1250.00</td>

                        <td>
                            <input type="number" value="1" min="1" class="qty-input">
                        </td>

                        <td>1250.00</td>

                        <td>
                            <button class="btn danger small">
                                Remove
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

        <!-- RIGHT SIDE -->
    <div class="pos-right">

        <!-- Summary -->
        <div class="card summary-card">

            <h3>Order Summary</h3>

            <div class="summary-row">
                <span>Items</span>
                <span>3</span>
            </div>

            <div class="summary-row">
                <span>Subtotal</span>
                <span>Rs. 1890.00</span>
            </div>

            <div class="summary-row total">
                <span>Grand Total</span>
                <span>Rs. 1890.00</span>
            </div>

        </div>

        <!-- Payment -->
        <div class="card payment-card">

            <h3>Payment</h3>

            <div class="form-group">

                <label>Customer Payment</label>

                <input
                    type="number"
                    placeholder="Enter amount">

            </div>

            <div class="summary-row balance">
                <span>Balance</span>
                <span>Rs. 110.00</span>
            </div>

        </div>

        <!-- Buttons -->
        <div class="card action-card">

            <button class="btn success full-btn">
                Complete Sale
            </button>

            <button class="btn secondary full-btn">
                Clear Cart
            </button>

        </div>

    </div>
</section>
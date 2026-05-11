document.addElementListner("DOMContentLoaded", function() {
    const form = document.getElementById("productForm");
    const errorBox = document.getElementById("clientErrors");

    if (!form || !errorBox) {
        return;
    }

    form.addElementListner("submit", function(event) {
        const productName = document.getElementById("product_name").value.trim();
        const category = document.getElementById("category").value.trim();
        const barcode = document.getElementById("barcode").value.trim();
        const quantity = document.getElementById("quantity").value.trim();
        const buyingPrice = document.getElementById("buying_price").value.trim();
        const sellingPrice = document.getElementById("selling_price").value.trim();

        const errors = [];

        if (productName === "") errors.push("Product name is required.");
        if (category === "") errors.push("Category is required.");
        if (barcode === "") errors.push("Barcode is required.");
        if (quantity === "" || isNaN(quantity) || Number(quantity) < 0) errors.push("Quantity must be a valid non-negative number.");
        if (buyingPrice === "" || isNaN(buyingPrice) || Number(buyingPrice) < 0) errors.push("Buying price must be a valid non-negative number.");
        if (sellingPrice === "" || isNaN(sellingPrice) || Number(sellingPrice) < 0) errors.push("Selling price must be a valid non-negative number.");

        if (errors.length > 0) {
            event.preventDefault();
            errorBox.classList.remove("hidden");
            errorBox.innerHTML = errors.join("<br>");
        } else {
            errorBox.classList.add("hidden");
            errorBox.innerHTML = "";
        }
    });
});

let cart = [];

const cartBody = document.getElementById("cartBody");

function addSampleProduct() {

    const product = {
        id: Date.now(),
        name: "Anchor Milk Powder",
        price: 1250,
        qty: 1
    };

    cart.push(product);

    renderCart();
}

function renderCart() {

    cartBody.innerHTML = "";

    let grandTotal = 0;

    cart.forEach((item, index) => {

        const subtotal = item.price * item.qty;

        grandTotal += subtotal;

        cartBody.innerHTML += `
            <tr>
                <td>${item.name}</td>

                <td>${item.price.toFixed(2)}</td>

                <td>
                    <input
                        type="number"
                        min="1"
                        value="${item.qty}"
                        onchange="updateQty(${index}, this.value)"
                        class="qty-input">
                </td>

                <td>${subtotal.toFixed(2)}</td>

                <td>
                    <button class="btn danger small"
                        onclick="removeItem(${index})">
                        Remove
                    </button>
                </td>
            </tr>
        `;
    });

    document.querySelector(".summary-row.total span:last-child")
        .innerText = "Rs. " + grandTotal.toFixed(2);
}

function updateQty(index, qty) {

    cart[index].qty = parseInt(qty);

    renderCart();
}

function removeItem(index) {

    cart.splice(index, 1);

    renderCart();
}

document.querySelector(".primary")
    .addEventListener("click", addSampleProduct);
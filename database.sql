CREATE DATABASE IF NOT EXISTS ekamuthu_inventory;
USE ekamuthu_inventory;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    barcode VARCHAR(50) NOT NULL,
    quantity INT NOT NULL,
    buying_price DECIMAL(10,2) NOT NULL,
    selling_price DECIMAL(10,2) NOT NULL,
    expiry_date DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (product_name, category, barcode, quantity, buying_price, selling_price, expiry_date) VALUES
('Milk Powder 400g', 'Grocery', '100001', 12, 850.00, 950.00, '2026-12-31'),
('Rice 1kg', 'Grocery', '100002', 25, 190.00, 220.00, NULL),
('Tea Packet', 'Beverages', '100003', 4, 120.00, 150.00, '2027-01-15'),
('Soap Bar', 'Household', '100004', 6, 75.00, 95.00, NULL);
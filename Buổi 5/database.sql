CREATE DATABASE IF NOT EXISTS shopping_cart CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE shopping_cart;

-- Bảng sản phẩm
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);

-- Bảng người dùng
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Thêm 5 sản phẩm mẫu
INSERT INTO products (name, price, quantity) VALUES
('Áo phông nam', 150000, 20),
('Quần Jeans', 350000, 15),
('Giày Sneaker', 550000, 10),
('Mũ Cùng', 80000, 30),
('Balo học sinh', 250000, 8);

-- Thêm 1 tài khoản mẫu: admin / password123
INSERT INTO users (username, password) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
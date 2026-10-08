CREATE DATABASE IF NOT EXISTS shopping_cart;
USE shopping_cart;

CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);

INSERT INTO products (name, price, quantity) VALUES
('Sản phẩm 1', 150000.00, 10),
('Sản phẩm 2', 250000.00, 5),
('Sản phẩm 3', 500000.00, 20),
('Sản phẩm 4', 120000.00, 15),
('Sản phẩm 5', 99000.00, 8);
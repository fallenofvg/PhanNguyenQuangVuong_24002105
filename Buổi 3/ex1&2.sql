-- CREATE DATABASE IF NOT EXISTS shopping_cart;
-- USE shopping_cart;

CREATE TABLE IF NOT EXISTS cart_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);

INSERT INTO cart_items (name, price, quantity) VALUES
('Áo phông Uniqlo', 150000.00, 10),
('Quần Jean Levi', 500000.00, 3),
('Tất cổ ngắn', 20000.00, 15),
('Mũ bảo hiểm', 250000.00, 4),
('Balo học sinh', 320000.00, 6);

SELECT * FROM cart_items;

SELECT * FROM cart_items 
WHERE price > 100000;

SELECT * FROM cart_items 
WHERE quantity > 5;

SELECT * FROM cart_items 
ORDER BY price DESC;

UPDATE cart_items 
SET price = 180000.00 
WHERE id = 1;

UPDATE cart_items 
SET quantity = 8 
WHERE id = 2;

DELETE FROM cart_items 
WHERE id = 3;

SELECT name, price, quantity, (price * quantity) AS thanh_tien 
FROM cart_items;

SELECT SUM(price * quantity) AS tong_tien_gio_hang 
FROM cart_items;


CREATE TABLE IF NOT EXISTS movies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    `total seats` INT NOT NULL,
    `available seats` INT NOT NULL
);

INSERT INTO movies (title, price, `total seats`, `available seats`) VALUES
('Dune: Part Two', 120000.00, 150, 40),
('Kung Fu Panda 4', 90000.00, 120, 60),
('Exhuma: Quật Mộ Trùng Phùng', 110000.00, 100, 20),
('Mai', 105000.00, 200, 30),
('Godzilla x Kong', 130000.00, 180, 80);

SELECT * FROM movies;

SELECT * FROM movies 
WHERE price > 100000;

SELECT * FROM movies 
WHERE `available seats` > 50;

SELECT * FROM movies 
ORDER BY price DESC;

UPDATE movies 
SET `available seats` = 35 
WHERE id = 1;

DELETE FROM movies 
WHERE id = 5;

SELECT title, (`total seats` - `available seats`) AS ve_da_ban 
FROM movies;

SELECT title, ((`total seats` - `available seats`) * price) AS doanh_thu 
FROM movies;

SELECT SUM((`total seats` - `available seats`) * price) AS tong_doanh_thu 
FROM movies;

SELECT title, (`total seats` - `available seats`) AS ve_da_ban 
FROM movies 
ORDER BY ve_da_ban DESC 
LIMIT 1;
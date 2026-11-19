-- Thêm cột image vào bảng products
ALTER TABLE products ADD COLUMN image VARCHAR(255) NULL DEFAULT NULL;

-- Bổ sung dữ liệu mẫu để test phân trang (ít nhất 12 bản ghi)
INSERT INTO products (name, price, description) VALUES 
('Sản phẩm mẫu 1', 100000, 'Mô tả sản phẩm 1'),
('Sản phẩm mẫu 2', 150000, 'Mô tả sản phẩm 2'),
('Sản phẩm mẫu 3', 200000, 'Mô tả sản phẩm 3'),
('Sản phẩm mẫu 4', 250000, 'Mô tả sản phẩm 4'),
('Sản phẩm mẫu 5', 300000, 'Mô tả sản phẩm 5'),
('Sản phẩm mẫu 6', 350000, 'Mô tả sản phẩm 6'),
('Sản phẩm mẫu 7', 400000, 'Mô tả sản phẩm 7'),
('Sản phẩm mẫu 8', 450000, 'Mô tả sản phẩm 8'),
('Sản phẩm mẫu 9', 500000, 'Mô tả sản phẩm 9'),
('Sản phẩm mẫu 10', 550000, 'Mô tả sản phẩm 10'),
('Sản phẩm mẫu 11', 600000, 'Mô tả sản phẩm 11'),
('Sản phẩm mẫu 12', 650000, 'Mô tả sản phẩm 12');

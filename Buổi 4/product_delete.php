<?php
require_once 'model/product.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: product_list.php');
    exit;
}

$product = getProductById($id);

if (!$product) {
    include 'view/header.php';
    echo "<h2>Thông báo</h2>";
    echo "<p style='color: red;'>Sản phẩm không tồn tại hoặc đã bị xóa!</p>";
    echo "<p><a href='product_list.php'>Quay lại danh sách</a></p>";
    include 'view/footer.php';
    exit;
}

// Tiến hành xóa nếu sản phẩm tồn tại[cite: 2]
deleteProduct($id);
header('Location: product_list.php');
exit;
?>
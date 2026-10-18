<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'model/product.php';

$id = $_GET['id'] ?? null;
$product = null;

if ($id) {
    $product = getProductById($id);
}

if (!$product) {
    include 'view/header.php';
    echo "<p class='error'>Sản phẩm không tồn tại hoặc đã bị xóa!</p>";
    echo "<a href='product_list.php'>Quay lại danh sách</a>";
    include 'view/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    deleteProduct($id);
    header("Location: product_list.php");
    exit;
}

include 'view/header.php';
?>

<h3>Xác nhận xóa sản phẩm</h3>
<p>Bạn có chắc chắn muốn xóa sản phẩm <strong><?= htmlspecialchars($product['name']) ?></strong> không?</p>

<form method="POST">
    <button type="submit">Đồng ý Xóa</button>
    <a href="product_list.php">Hủy bỏ</a>
</form>

<?php include 'view/footer.php'; ?>
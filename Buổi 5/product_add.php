<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'model/product.php';

$error = '';
$name = '';
$price = '';
$quantity = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = $_POST['price'] ?? '';
    $quantity = $_POST['quantity'] ?? '';

    // Validate dữ liệu
    if (empty($name)) {
        $error = "Tên sản phẩm không được để rỗng!";
    } elseif (!is_numeric($price) || $price <= 0) {
        $error = "Giá sản phẩm phải là số và lớn hơn 0!";
    } elseif (!is_numeric($quantity) || $quantity < 0) {
        $error = "Số lượng sản phẩm phải lớn hơn hoặc bằng 0!";
    } else {
        if (addProduct($name, $price, $quantity)) {
            header("Location: product_list.php");
            exit;
        } else {
            $error = "Thêm sản phẩm thất bại!";
        }
    }
}

include 'view/header.php';
?>

<h3>Thêm sản phẩm mới</h3>
<?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>

<form method="POST">
    <div>
        <label>Tên sản phẩm:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">
    </div>
    <div>
        <label>Giá:</label><br>
        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($price) ?>">
    </div>
    <div>
        <label>Số lượng:</label><br>
        <input type="number" name="quantity" value="<?= htmlspecialchars($quantity) ?>">
    </div>
    <button type="submit">Lưu sản phẩm</button>
    <a href="product_list.php">Hủy</a>
</form>

<?php include 'view/footer.php'; ?>
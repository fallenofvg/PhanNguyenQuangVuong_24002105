<?php
require_once 'model/product.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: product_list.php');
    exit;
}

$product = getProductById($id);
if (!$product) {
    die('Sản phẩm không tồn tại!');
}

$errors = [];
$name = $product['name'];
$price = $product['price'];
$quantity = $product['quantity'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $quantity = trim($_POST['quantity'] ?? '');

    // Validation[cite: 2]
    if (empty($name)) {
        $errors[] = 'Tên sản phẩm không được rỗng.';
    }
    if (!is_numeric($price) || $price <= 0) {
        $errors[] = 'Giá sản phẩm phải là số và lớn hơn 0.';
    }
    if (!is_numeric($quantity) || $quantity < 0) {
        $errors[] = 'Số lượng phải là số nguyên không âm (>= 0).';
    }

    if (empty($errors)) {
        if (updateProduct($id, $name, $price, $quantity)) {
            header('Location: product_list.php');
            exit;
        } else {
            $errors[] = 'Có lỗi xảy ra khi cập nhật sản phẩm.';
        }
    }
}

include 'view/header.php';
?>

<h2>Sửa sản phẩm</h2>

<?php if (!empty($errors)): ?>
    <ul style="color: red;">
        <?php foreach ($errors as $error): ?>
            <li><?php echo $error; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="product_edit.php?id=<?php echo $id; ?>" method="POST">
    <p>
        <label>Tên sản phẩm:</label><br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
    </p>
    <p>
        <label>Giá:</label><br>
        <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($price); ?>">
    </p>
    <p>
        <label>Số lượng:</label><br>
        <input type="number" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>">
    </p>
    <p>
        <button type="submit">Cập nhật</button>
        <a href="product_list.php">Hủy</a>
    </p>
</form>

<?php include 'view/footer.php'; ?>
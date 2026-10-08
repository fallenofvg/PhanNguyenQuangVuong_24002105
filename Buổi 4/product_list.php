<?php
require_once 'model/product.php';
$products = getAllProducts();

include 'view/header.php';
?>

<h2>Danh sách sản phẩm</h2>
<p><a href="product_add.php">+ Thêm sản phẩm mới</a></p>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Chức năng</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $item): ?>
                <tr>
                    <td><?php echo $item['id']; ?></td>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VNĐ</td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>
                        <a href="product_edit.php?id=<?php echo $item['id']; ?>">Sửa</a> | 
                        <a href="product_delete.php?id=<?php echo $item['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Chưa có sản phẩm nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include 'view/footer.php'; ?>
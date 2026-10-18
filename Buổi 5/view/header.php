<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý giỏ hàng</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header-bar { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .error { color: red; }
        .success { color: green; }
        form div { margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header-bar">
        <h2>Hệ thống Quản lý Sản phẩm</h2>
        <?php if (isset($_SESSION['user_id'])): ?>
            <div>
                Xin chào, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong> | 
                <a href="logout.php">Đăng xuất</a>
            </div>
        <?php endif; ?>
    </div>
    <hr>
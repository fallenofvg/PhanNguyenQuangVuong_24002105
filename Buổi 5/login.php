<?php
session_start();
require_once 'common/dbConnect.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = "Vui lòng nhập tên đăng nhập và mật khẩu!";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: product_list.php");
            exit;
        } else {
            $error = "Tên đăng nhập hoặc mật khẩu không chính xác!";
        }
    }
}

include 'view/header.php';
?>

<h3>Đăng nhập hệ thống</h3>
<?php if (isset($_GET['registered'])): ?>
    <p class="success">Đăng ký thành công! Vui lòng đăng nhập.</p>
<?php endif; ?>
<?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>

<form method="POST">
    <div>
        <label>Tên đăng nhập:</label><br>
        <input type="text" name="username" required>
    </div>
    <div>
        <label>Mật khẩu:</label><br>
        <input type="password" name="password" required>
    </div>
    <button type="submit">Đăng nhập</button>
</form>
<p>Chưa có tài khoản? <a href="register.php">Đăng ký tại đây</a></p>

<?php include 'view/footer.php'; ?>
<?php
session_start();
require_once 'common/dbConnect.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = "Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu!";
    } else {
        // Kiểm tra username đã tồn tại chưa
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        if ($stmt->fetch()) {
            $error = "Tên đăng nhập đã tồn tại!";
        } else {
            // Mã hóa mật khẩu và lưu
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmtInsert = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            if ($stmtInsert->execute(['username' => $username, 'password' => $hashedPassword])) {
                header("Location: login.php?registered=1");
                exit;
            } else {
                $error = "Đã xảy ra lỗi khi đăng ký!";
            }
        }
    }
}

include 'view/header.php';
?>

<h3>Đăng ký tài khoản</h3>
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
    <button type="submit">Đăng ký</button>
</form>
<p>Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>

<?php include 'view/footer.php'; ?>
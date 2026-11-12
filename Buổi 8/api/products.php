<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Xử lý request preflight OPTIONS của CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$host = 'localhost';
$db   = 'shop_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo json_encode(["success" => false, "message" => "Kết nối CSDL thất bại: " . $e->getMessage()]);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        try {
            $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
            $products = $stmt->fetchAll();
            echo json_encode(["success" => true, "data" => $products]);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $name = trim($data['name'] ?? '');
        $price = filter_var($data['price'] ?? null, FILTER_VALIDATE_INT);
        $stock = filter_var($data['stock'] ?? null, FILTER_VALIDATE_INT);

        // Kiểm tra dữ liệu
        if (mb_strlen($name) < 1 || mb_strlen($name) > 100 || $price === false || $price <= 0 || $stock === false || $stock < 0) {
            echo json_encode(["success" => false, "message" => "Dữ liệu không hợp lệ!"]);
            exit();
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO products (name, price, stock) VALUES (?, ?, ?)");
            $stmt->execute([$name, $price, $stock]);
            echo json_encode(["success" => true, "message" => "Thêm sản phẩm thành công!"]);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
        break;

    case 'PUT':
        $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
        if (!$id) {
            echo json_encode(["success" => false, "message" => "ID không hợp lệ!"]);
            exit();
        }

        $data = json_decode(file_get_contents("php://input"), true);
        $name = trim($data['name'] ?? '');
        $price = filter_var($data['price'] ?? null, FILTER_VALIDATE_INT);
        $stock = filter_var($data['stock'] ?? null, FILTER_VALIDATE_INT);

        if (mb_strlen($name) < 1 || mb_strlen($name) > 100 || $price === false || $price <= 0 || $stock === false || $stock < 0) {
            echo json_encode(["success" => false, "message" => "Dữ liệu không hợp lệ!"]);
            exit();
        }

        try {
            // Kiểm tra sản phẩm có tồn tại không
            $check = $pdo->prepare("SELECT id FROM products WHERE id = ?");
            $check->execute([$id]);
            if ($check->rowCount() === 0) {
                echo json_encode(["success" => false, "message" => "Sản phẩm không tồn tại!"]);
                exit();
            }

            $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, stock = ? WHERE id = ?");
            $stmt->execute([$name, $price, $stock, $id]);
            echo json_encode(["success" => true, "message" => "Cập nhật thành công!"]);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
        break;

    case 'DELETE':
        $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
        if (!$id) {
            echo json_encode(["success" => false, "message" => "ID không hợp lệ!"]);
            exit();
        }

        try {
            $check = $pdo->prepare("SELECT id FROM products WHERE id = ?");
            $check->execute([$id]);
            if ($check->rowCount() === 0) {
                echo json_encode(["success" => false, "message" => "Sản phẩm không tồn tại!"]);
                exit();
            }

            $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(["success" => true, "message" => "Xóa thành công!"]);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["success" => false, "message" => "Phương thức không được hỗ trợ!"]);
        break;
}
?>
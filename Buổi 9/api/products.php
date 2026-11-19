<?php
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Lấy tham số, mặc định page = 1, limit = 5
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? $_GET['limit'] : 5;

        // Kiểm tra tham số phải là số nguyên dương
        if (!filter_var($page, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]) || 
            !filter_var($limit, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Tham số page hoặc limit không hợp lệ.']);
            exit;
        }

        $page = (int)$page;
        $limit = (int)$limit;

        // Đếm tổng số sản phẩm
        $stmtCount = $pdo->query("SELECT COUNT(*) FROM products");
        $total = (int)$stmtCount->fetchColumn();

        // Tính tổng số trang (tối thiểu là 1)
        $total_pages = $total > 0 ? (int)ceil($total / $limit) : 1;

        // Nếu page vượt trang cuối, trả về dữ liệu của trang cuối cùng
        if ($page > $total_pages) {
            $page = $total_pages;
        }

        $offset = ($page - 1) * $limit;

        // Lấy danh sách sản phẩm theo trang, sắp xếp id giảm dần
        $stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll();

        echo json_encode([
            'success' => true,
            'data' => $products,
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => $total,
                'total_pages' => $total_pages
            ]
        ]);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $name = trim($input['name'] ?? '');
        $price = $input['price'] ?? 0;
        $description = trim($input['description'] ?? '');

        if (empty($name) || !is_numeric($price) || $price < 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Tên sản phẩm không được trống và giá phải hợp lệ.']);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO products (name, price, description) VALUES (?, ?, ?)");
        $stmt->execute([$name, $price, $description]);
        $newId = $pdo->lastInsertId();

        echo json_encode([
            'success' => true,
            'message' => 'Thêm sản phẩm thành công.',
            'id' => (int)$newId // Trả về mã sản phẩm mới cho Vue upload ảnh
        ]);
        break;

    case 'PUT':
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? 0;
        $name = trim($input['name'] ?? '');
        $price = $input['price'] ?? 0;
        $description = trim($input['description'] ?? '');

        if (!$id || empty($name) || !is_numeric($price) || $price < 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Dữ liệu cập nhật không hợp lệ.']);
            exit;
        }

        $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, description = ? WHERE id = ?");
        $stmt->execute([$name, $price, $description, $id]);

        echo json_encode([
            'success' => true,
            'message' => 'Cập nhật sản phẩm thành công.',
            'id' => (int)$id
        ]);
        break;

    case 'DELETE':
        $id = $_GET['id'] ?? 0;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Thiếu ID sản phẩm.']);
            exit;
        }

        // Xóa file ảnh vật lý nếu có
        $stmtImg = $pdo->prepare("SELECT image FROM products WHERE id = ?");
        $stmtImg->execute([$id]);
        $oldImage = $stmtImg->fetchColumn();
        if ($oldImage && file_exists('../' . $oldImage)) {
            unlink('../' . $oldImage);
        }

        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);

        echo json_encode(['success' => true, 'message' => 'Xóa sản phẩm thành công.']);
        break;
}
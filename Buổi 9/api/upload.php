<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Phương thức không được hỗ trợ.']);
    exit;
}

$productId = $_POST['product_id'] ?? null;
if (!$productId || !filter_var($productId, FILTER_VALIDATE_INT)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Mã sản phẩm không hợp lệ.']);
    exit;
}

// 1. Kiểm tra sản phẩm có tồn tại trong DB không
$stmt = $pdo->prepare("SELECT id, image FROM products WHERE id = ?");
$stmt->execute([$productId]);
$product = $stmt->fetch();

if (!$product) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại.']);
    exit;
}

// 2. Kiểm tra file gửi lên
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Vui lòng chọn file ảnh hợp lệ để tải lên.']);
    exit;
}

$file = $_FILES['image'];

// 3. Kiểm tra dung lượng tối đa 2MB
$maxSize = 2 * 1024 * 1024;
if ($file['size'] > $maxSize) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Dung lượng ảnh vượt quá giới hạn 2 MB.']);
    exit;
}

// 4. Kiểm tra loại ảnh thực tế bằng Fileinfo (chỉ nhận JPG/JPEG và PNG)
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$realMimeType = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

$allowedMimes = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png'
];

if (!array_key_exists($realMimeType, $allowedMimes)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Định dạng file không hợp lệ. Chỉ chấp nhận JPG, JPEG hoặc PNG.']);
    exit;
}

// 5. Tạo thư mục uploads nếu chưa có & tạo tên file duy nhất
$uploadDir = '../uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$extension = $allowedMimes[$realMimeType];
$uniqueFileName = 'prod_' . $productId . '_' . uniqid() . '.' . $extension;
$targetFilePath = $uploadDir . $uniqueFileName;
$dbImagePath = 'uploads/' . $uniqueFileName;

// 6. Lưu file và cập nhật DB
if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
    // Xóa ảnh cũ nếu sản phẩm đã có ảnh trước đó
    if (!empty($product['image']) && file_exists('../' . $product['image'])) {
        unlink('../' . $product['image']);
    }

    $updateStmt = $pdo->prepare("UPDATE products SET image = ? WHERE id = ?");
    $updateStmt->execute([$dbImagePath, $productId]);

    echo json_encode([
        'success' => true,
        'message' => 'Upload ảnh thành công.',
        'image' => $dbImagePath
    ]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Lỗi hệ thống khi lưu file ảnh.']);
}
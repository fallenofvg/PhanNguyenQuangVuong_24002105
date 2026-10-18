<?php
require_once __DIR__ . '/../common/dbConnect.php';

function getAllProducts() {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM products ORDER BY id DESC");
    $stmt->execute();
    return $stmt->fetchAll();
}

function getProductById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}

function addProduct($name, $price, $quantity) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO products (name, price, quantity) VALUES (:name, :price, :quantity)");
    return $stmt->execute([
        'name' => $name,
        'price' => $price,
        'quantity' => $quantity
    ]);
}

function updateProduct($id, $name, $price, $quantity) {
    global $conn;
    $stmt = $conn->prepare("UPDATE products SET name = :name, price = :price, quantity = :quantity WHERE id = :id");
    return $stmt->execute([
        'id' => $id,
        'name' => $name,
        'price' => $price,
        'quantity' => $quantity
    ]);
}

function deleteProduct($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
    return $stmt->execute(['id' => $id]);
}
?>
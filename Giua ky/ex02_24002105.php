<?php

$prices = [150000, 320000, 850000, 450000, 200000];

function calculateTotal($prices) {
    $total = 0;
    foreach ($prices as $price) {
        $total += $price;
    }
    return $total;
}

function findMaxPrice($prices) {
    if (empty($prices)) {
        return 0;
    }
    $max = $prices[0];
    foreach ($prices as $price) {
        if ($price > $max) {
            $max = $price;
        }
    }
    return $max;
}

$totalPrice = calculateTotal($prices);
$maxPrice = findMaxPrice($prices);

echo "Quản lý giá sản phẩm :<br>";
echo "Danh sách giá sản phẩm: " . implode(", ", $prices) . " VNĐ<br>";
echo "Tổng giá trị sản phẩm: " . number_format($totalPrice, 0, ',', '.') . " VNĐ<br>";
echo "Giá sản phẩm cao nhất: " . number_format($maxPrice, 0, ',', '.') . " VNĐ<br>";
?>
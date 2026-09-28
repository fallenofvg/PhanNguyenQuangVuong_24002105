<?php
class CartItem {
    private string $name;
    private float $price;
    private int $quantity;

    public function __construct(string $name, float $price, int $quantity) {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function getQuantity(): int {
        return $this->quantity;
    }

    public function getTotal(): float {
        return $this->price * $this->quantity;
    }
}

class ShoppingCart {
    private array $items = [];

    public function addItem(CartItem $item): void {
        if ($item->getPrice() <= 0) {
            echo "<p style='color: red;'>Lỗi: Giá sản phẩm '{$item->getName()}' phải lớn hơn 0!</p>";
            return;
        }

        if ($item->getQuantity() <= 0) {
            echo "<p style='color: red;'>Lỗi: Số lượng sản phẩm '{$item->getName()}' phải lớn hơn 0!</p>";
            return;
        }

        $this->items[] = $item;
        echo "<p style='color: green;'>Đã thêm sản phẩm '{$item->getName()}' vào giỏ hàng.</p>";
    }

    public function removeItem(string $name): void {
        $foundIndex = -1;
        foreach ($this->items as $index => $item) {
            if (strcasecmp($item->getName(), $name) === 0) {
                $foundIndex = $index;
                break;
            }
        }

        if ($foundIndex !== -1) {
            array_splice($this->items, $foundIndex, 1);
            echo "<p style='color: green;'>Đã xóa sản phẩm '{$name}' khỏi giỏ hàng.</p>";
        } else {
            echo "<p style='color: red;'>Lỗi: Không tìm thấy sản phẩm '{$name}' trong giỏ hàng để xóa!</p>";
        }
    }

    public function calculateTotal(): float {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getTotal();
        }
        return $total;
    }

    public function displayCart(): void {
        echo "<h3>--- GIỎ HÀNG CỦA BẠN ---</h3>";
        if (empty($this->items)) {
            echo "<p>Giỏ hàng đang trống.</p>";
            echo "<p><strong>Tổng tiền: 0 VNĐ</strong></p>";
            return;
        }

        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr>
                <th>Tên sản phẩm</th>
                <th>Đơn giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
              </tr>";

        foreach ($this->items as $item) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($item->getName()) . "</td>";
            echo "<td>" . number_format($item->getPrice()) . " VNĐ</td>";
            echo "<td>" . $item->getQuantity() . "</td>";
            echo "<td>" . number_format($item->getTotal()) . " VNĐ</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<p><strong>Tổng tiền toàn giỏ hàng: " . number_format($this->calculateTotal()) . " VNĐ</strong></p>";
    }
}

echo "<h2>BÀI 1: GIỎ HÀNG MUA SẮM</h2>";

$cart = new ShoppingCart();

$item1 = new CartItem("Laptop Dell", 15000000, 1);
$item2 = new CartItem("Chuột Logitech", 350000, 2);
$item3 = new CartItem("Bàn phím cơ", 1200000, 1);
$item4 = new CartItem("Tai nghe Bluetooth", 800000, 1);

$cart->addItem($item1);
$cart->addItem($item2);
$cart->addItem($item3);
$cart->addItem($item4);

echo "<h4>Kiểm thử dữ liệu đầu vào không hợp lệ:</h4>";
$invalidItem1 = new CartItem("Sản phẩm giá sai", -50000, 1);
$invalidItem2 = new CartItem("Sản phẩm số lượng sai", 100000, 0);
$cart->addItem($invalidItem1);
$cart->addItem($invalidItem2);

echo "<h4>1. Danh sách giỏ hàng ban đầu:</h4>";
$cart->displayCart();

echo "<h4>2. Thực hiện xóa sản phẩm:</h4>";
$cart->removeItem("Chuột Logitech");
$cart->removeItem("Màn hình Samsung");

echo "<h4>3. Giỏ hàng sau khi xóa:</h4>";
$cart->displayCart();
?>
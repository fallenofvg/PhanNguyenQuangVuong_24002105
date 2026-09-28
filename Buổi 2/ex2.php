<?php
class Movie {
    private int $id;
    private string $title;
    private float $price;
    private int $totalSeats;
    private int $availableSeats;

    public function __construct(int $id, string $title, float $price, int $totalSeats) {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->totalSeats = $totalSeats;
        $this->availableSeats = $totalSeats;
    }

    public function getId(): int { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function getPrice(): float { return $this->price; }
    public function getTotalSeats(): int { return $this->totalSeats; }
    public function getAvailableSeats(): int { return $this->availableSeats; }

    public function bookTicket(int $quantity): bool {
        if ($quantity <= 0) {
            echo "<p style='color: red;'>Lỗi [Phim {$this->title}]: Số lượng vé đặt phải lớn hơn 0!</p>";
            return false;
        }

        if ($quantity > $this->availableSeats) {
            echo "<p style='color: red;'>Lỗi [Phim {$this->title}]: Không thể đặt {$quantity} vé! (Chỉ còn {$this->availableSeats} ghế trống)</p>";
            return false;
        }

        $this->availableSeats -= $quantity;
        echo "<p style='color: green;'>Đặt thành công {$quantity} vé cho phim '{$this->title}'.</p>";
        return true;
    }

    public function cancelTicket(int $quantity): bool {
        if ($quantity <= 0) {
            echo "<p style='color: red;'>Lỗi [Phim {$this->title}]: Số lượng vé hủy phải lớn hơn 0!</p>";
            return false;
        }

        $soldSeats = $this->getSoldSeats();
        if ($quantity > $soldSeats) {
            echo "<p style='color: red;'>Lỗi [Phim {$this->title}]: Không thể hủy {$quantity} vé! (Đã bán {$soldSeats} vé)</p>";
            return false;
        }

        $this->availableSeats += $quantity;
        echo "<p style='color: green;'>Hủy thành công {$quantity} vé của phim '{$this->title}'.</p>";
        return true;
    }

    public function getSoldSeats(): int {
        return $this->totalSeats - $this->availableSeats;
    }

    public function getRevenue(): float {
        return $this->getSoldSeats() * $this->price;
    }

    public function displayInfo(): void {
        echo "<tr>";
        echo "<td>{$this->id}</td>";
        echo "<td>" . htmlspecialchars($this->title) . "</td>";
        echo "<td>" . number_format($this->price) . " VNĐ</td>";
        echo "<td>{$this->totalSeats}</td>";
        echo "<td>{$this->availableSeats}</td>";
        echo "<td>" . $this->getSoldSeats() . "</td>";
        echo "<td>" . number_format($this->getRevenue()) . " VNĐ</td>";
        echo "</tr>";
    }
}

function findMovieById(array $movies, int $id): ?Movie {
    foreach ($movies as $movie) {
        if ($movie->getId() === $id) {
            return $movie;
        }
    }
    return null;
}

function getTotalRevenue(array $movies): float {
    if (empty($movies)) return 0;

    $totalRevenue = 0;
    foreach ($movies as $movie) {
        $totalRevenue += $movie->getRevenue();
    }
    return $totalRevenue;
}

function getBestSellingMovie(array $movies): ?Movie {
    if (empty($movies)) return null;

    $bestMovie = $movies[0];
    foreach ($movies as $movie) {
        if ($movie->getSoldSeats() > $bestMovie->getSoldSeats()) {
            $bestMovie = $movie;
        }
    }
    return $bestMovie;
}

function displayAllMovies(array $movies): void {
    if (empty($movies)) {
        echo "<p>Danh sách phim rỗng!</p>";
        return;
    }

    echo "<table border='1' cellpadding='8' cellspacing='0'>";
    echo "<tr>
            <th>ID</th>
            <th>Tên phim</th>
            <th>Giá vé</th>
            <th>Tổng ghế</th>
            <th>Ghế còn</th>
            <th>Vé đã bán</th>
            <th>Doanh thu</th>
          </tr>";

    foreach ($movies as $movie) {
        $movie->displayInfo();
    }
    echo "</table>";
}

echo "<h2>BÀI 2: QUẢN LÝ VÉ XEM PHIM</h2>";

$movies = [
    new Movie(1, "Avengers", 100000, 100),
    new Movie(2, "Avatar", 120000, 80),
    new Movie(3, "Batman", 90000, 120)
];

echo "<h4>1. Thực hiện đặt và hủy vé:</h4>";

$avengers = findMovieById($movies, 1);
if ($avengers) {
    $avengers->bookTicket(30);
}

$avatar = findMovieById($movies, 2);
if ($avatar) {
    $avatar->bookTicket(50);
}

if ($avengers) {
    $avengers->cancelTicket(5);
}

echo "<h4>2. Kiểm thử các trường hợp dữ liệu không hợp lệ:</h4>";
if ($avengers) {
    $avengers->bookTicket(-5);
    $avengers->bookTicket(200);
    $avengers->cancelTicket(-2);
    $avengers->cancelTicket(1000);
}

$notFoundMovie = findMovieById($movies, 999);
if (!$notFoundMovie) {
    echo "<p style='color: red;'>Kiểm thử: Không tìm thấy phim có ID = 999!</p>";
}

echo "<p style='color: gray;'>Kiểm thử danh sách rỗng: Tổng doanh thu = " . number_format(getTotalRevenue([])) . " VNĐ</p>";

echo "<h4>3. Bảng thông tin tất cả các phim hiện tại:</h4>";
displayAllMovies($movies);

echo "<h4>4. Tổng doanh thu hệ thống:</h4>";
echo "<p><strong>Tổng doanh thu: " . number_format(getTotalRevenue($movies)) . " VNĐ</strong></p>";

echo "<h4>5. Phim bán chạy nhất:</h4>";
$bestSelling = getBestSellingMovie($movies);
if ($bestSelling) {
    echo "<p>Phim bán chạy nhất là: <strong>{$bestSelling->getTitle()}</strong> với <strong>{$bestSelling->getSoldSeats()}</strong> vé đã bán.</p>";
}
?>
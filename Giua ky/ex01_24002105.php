<?php

$name = "Phan Nguyen Quang Vuong";
$score = 7.5;


if ($score >= 8.0) {
    $rank = "Giỏi";
} elseif ($score >= 6.5) {
    $rank = "Khá";
} elseif ($score >= 5.0) {
    $rank = "Trung bình";
} else {
    $rank = "Yếu";
}


echo "Kết quả xếp loại :";
echo "Tên học sinh: " . $name . "<br>";
echo "Điểm số: " . $score . "<br>";
echo "Xếp loại: " . $rank . "<br>";
?>
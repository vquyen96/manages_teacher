<?php
// Thiết lập các biến kết nối với CSDL
$host = "localhost";
$db_name = "manages";
$username = "root";
$password = "";

try {
    $con = new PDO("mysql:host=127.0.0.1;dbname=".$db_name, $username, $password);
}

// Hiển thị lỗi nếu quá trình kết nối xảy ra vấn đề
catch(PDOException $exception){
    echo "Connection error: " . $exception->getMessage();
}

$genders = [
    0 => 'Nữ',
    1 => 'Nam',
    2 => 'Khác',
];

$roles = [
    1 => 'Quản lý',
    2 => 'Giáo viên',
];

$ranks = [
    1 => 'Thiếu úy',
    2 => 'Trung úy',
    3 => 'Thượng úy',
    4 => 'Đại úy',
    5 => 'Thiếu tá',
    6 => 'Trung tá',
    7 => 'Thượng tá',
    8 => 'Đại tá'
];
?>
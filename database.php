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
?>
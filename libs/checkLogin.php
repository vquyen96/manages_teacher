<?php
try {
    $token = session_get('token');

    // chuẩn bị truy vấn SELECT
    $query = "SELECT * FROM tai_khoan WHERE ma_dang_nhap = ? LIMIT 0,1";
    $stmt = $con->prepare( $query );

    // truyền giá trị cho tham số ‘?’ trong câu truy vấn bên trên
    $stmt->bindParam(1, $token);

    // thực thi truy vấn
    $stmt->execute();

    $num = $stmt->rowCount();
    if ($num == 0) {
        session_delete('token');
        return header("Location: ../dangnhap.php");
    }

    // lưu bản ghi dữ liệu lấy được vào một biến ‘row’
    $auth = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($auth['ngay_het_han'] < time()) {
        session_delete('token');
        return header("Location: ../dangnhap.php");
    }

    // điền giá trị lấy được từ $row vào trong form
//    $name = $row['name'];
//    $description = $row['description'];
//    $price = $row['price'];
//    $image = htmlspecialchars($auth['ho_ten'], ENT_QUOTES);
}

// hiển thị lỗi
catch(PDOException $exception){
    die('LỖI: ' . $exception->getMessage());
}
?>
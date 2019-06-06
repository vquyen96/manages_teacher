<?php
// include kết nối CSDL
include '../../database.php';

try {
    // lấy ID từ URL
    $id=isset($_GET['id']) ? $_GET['id'] : die('LỖI: Không tìm thấy ID.');

    // truy vấn xóa dữ liệu
    $query_giao_vien_nghien_cuu = "SELECT * FROM giao_vien_nghien_cuu WHERE id = ?";
    $stmt_giao_vien_nghien_cuu = $con->prepare( $query_giao_vien_nghien_cuu );
    $stmt_giao_vien_nghien_cuu->bindParam(1, $id);
    $stmt_giao_vien_nghien_cuu->execute();
    $ncgv = $stmt_giao_vien_nghien_cuu->fetch(PDO::FETCH_ASSOC);

    $query = "DELETE FROM giao_vien_nghien_cuu WHERE id = :id ";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header('Location: sua.php?id='.$ncgv['nghien_cuu_id']);
}

// Hiển thị lỗi
catch(PDOException $exception){
    die('LỖI: ' . $exception->getMessage());
}
?>
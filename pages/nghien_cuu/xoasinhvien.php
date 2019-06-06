<?php
// include kết nối CSDL
include '../../database.php';

try {
    // lấy ID từ URL
    $id=isset($_GET['id']) ? $_GET['id'] : die('LỖI: Không tìm thấy ID.');

    // truy vấn xóa dữ liệu
    $query_sv = "SELECT * FROM sinh_vien_nghien_cuu WHERE id = ?";
    $query_sv = $con->prepare( $query_sv );
    $query_sv->bindParam(1, $id);
    $query_sv->execute();
    $svnc = $query_sv->fetch(PDO::FETCH_ASSOC);

    $query = "DELETE FROM sinh_vien_nghien_cuu WHERE id = :id ";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header('Location: sua.php?id='.$svnc['nghien_cuu_id']);
}

// Hiển thị lỗi
catch(PDOException $exception){
    die('LỖI: ' . $exception->getMessage());
}
?>
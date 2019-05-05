<?php
//Hàm lấy chuỗi ngẫu nhiên theo độ dài
function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Hàm tại chuỗi id theo độ dài và bảng (id là duy nhất trong bảng)
function generateId($length, $table, $con) {
    do{
        $id = generateRandomString($length);
        $query_get_id = "SELECT * FROM ".$table." WHERE id=':id'" ;
        $stmt_get_id = $con->prepare($query_get_id);
        $stmt_get_id->bindParam(':id', $id);
        $stmt_get_id->execute();
        $exist_nghien_cuu = $stmt_get_id->fetchAll(PDO::FETCH_ASSOC);
        $continue = count($exist_nghien_cuu) != 0;
    }while($continue);

    return $id;
}

//Hàm lưu hình ảnh
function saveImage($file, $path) {

    $hinh_anh=!empty($file["name"])? sha1_file($file['tmp_name']) . "-" . basename($file["name"]): "";
    $hinh_anh=htmlspecialchars(strip_tags($hinh_anh));

    if ($hinh_anh) {
        // sha1_file() là hàm dùng tạo tên file ảnh là duy nhất
        $target_directory = $path;
        $target_file = $target_directory . $hinh_anh;
        $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

        // Thông báo lỗi nếu upload lỗi
        $file_upload_error_messages="";

        // các định dạng file ảnh được phép upload
        $allowed_file_types=array("jpg", "jpeg", "png", "gif", "doc", "docx", "pdf", 'pptx');
        if(!in_array($file_type, $allowed_file_types)){
            $file_upload_error_messages.="Chỉ cho phép upload các định dạng JPG, JPEG, PNG, GIF, DOC, PDF, PPTX";
        }

        // đảm bảo file ảnh khi sumit không quá 1 MB
        if($_FILES['hinh_anh']['size'] > (2048000)){
            $file_upload_error_messages.="Kích thước file nên dưới 2 MB.";
        }

        // đảm bảo thư mục “upload” được tồn tại
        // nếu chưa tồn tại, tiến hành tạo mới
        if(!is_dir($target_directory)){
            mkdir($target_directory, 0777, true);
        }

        // nếu $file_upload_error_messages là rỗng (không có lỗi)
        if(empty($file_upload_error_messages)){
            if(move_uploaded_file($file["tmp_name"], $target_file)){
                return $hinh_anh;
            }else{
                $file_upload_error_messages = "Lưu hình ảnh lỗi";
                session_set('error', $file_upload_error_messages);
                return false;

            }
        }
        // nếu $file_upload_error_messages là không rỗng (có vấn đề xảy ra)
        else{
            session_set('error', $file_upload_error_messages);
            return false;
        }
    }
    else{
        return $hinh_anh;
    }
}

// kiểm tra tên đăng nhập có tòn tại
function isValidUsername($ten_dang_nhap, $id, $con){
    $query = "SELECT * FROM tai_khoan WHERE ten_dang_nhap=':ten_dang_nhap' && id!=':id'" ;
    $stmt = $con->prepare($query);
    $stmt->bindParam(':ten_dang_nhap', $ten_dang_nhap);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $exist = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return  count($exist) != 0;
}

function dd($value){
    var_dump($value);
    die();
}


function kiem_tra_gvnc_ton_tai($giao_vien_id, $nghien_cuu_id, $con){
    $query_gvnc = "SELECT * FROM giao_vien_nghien_cuu WHERE giao_vien_id=:giao_vien_id && nghien_cuu_id=:nghien_cuu_id";

    $stmt_gvnc = $con->prepare($query_gvnc);
    $stmt_gvnc->bindParam(':giao_vien_id', $giao_vien_id);
    $stmt_gvnc->bindParam(':nghien_cuu_id', $nghien_cuu_id);
    $stmt_gvnc->execute();
    $exist = $stmt_gvnc->fetchAll(PDO::FETCH_ASSOC);

    return count($exist) == 0;
}

function kiem_tra_svnc_ton_tai($sinh_vien_id, $nghien_cuu_id, $con){
    $query_svnc = "SELECT * FROM sinh_vien_nghien_cuu WHERE sinh_vien_id=:sinh_vien_id && nghien_cuu_id=:nghien_cuu_id";

    $stmt_svnc = $con->prepare($query_svnc);
    $stmt_svnc->bindParam(':sinh_vien_id', $sinh_vien_id);
    $stmt_svnc->bindParam(':nghien_cuu_id', $nghien_cuu_id);
    $stmt_svnc->execute();
    $exist = $stmt_svnc->fetchAll(PDO::FETCH_ASSOC);
    return count($exist) == 0;
}

function tong_thoi_gian_gvnc($nghien_cuu_id, $con) {
    $query_gvnc = "SELECT SUM(thoi_gian) FROM giao_vien_nghien_cuu WHERE nghien_cuu_id=:nghien_cuu_id";

    $stmt_gvnc = $con->prepare($query_gvnc);
    $stmt_gvnc->bindParam(':nghien_cuu_id', $nghien_cuu_id);
    $stmt_gvnc->execute();
    $exist = $stmt_gvnc->fetch(PDO::FETCH_ASSOC);

    return $exist;
}

function tong_thoi_gian_svnc($nghien_cuu_id, $con) {
    $query_svnc = "SELECT SUM(thoi_gian) FROM sinh_vien_nghien_cuu WHERE nghien_cuu_id=:nghien_cuu_id";

    $stmt_svnc = $con->prepare($query_svnc);
    $stmt_svnc->bindParam(':nghien_cuu_id', $nghien_cuu_id);
    $stmt_svnc->execute();
    $exist = $stmt_svnc->fetch(PDO::FETCH_ASSOC);

    return $exist;
}

function cap_nhat_thoi_gian_svnc($sinh_vien_id, $con) {
    $query_svnc = "SELECT SUM(thoi_gian) FROM sinh_vien_nghien_cuu WHERE sinh_vien_id=:sinh_vien_id";

    $stmt_svnc = $con->prepare($query_svnc);
    $stmt_svnc->bindParam(':sinh_vien_id', $sinh_vien_id);
    $stmt_svnc->execute();
    $thoi_gian = $stmt_svnc->fetch(PDO::FETCH_ASSOC);

    $tong_thoi_gian = (int)$thoi_gian['SUM(thoi_gian)'];

    $query_sv = "UPDATE sinh_vien SET tong_thoi_gian=:tong_thoi_gian WHERE id=:id";
    $stmt_sv = $con->prepare($query_sv);
    $stmt_sv->bindParam(':tong_thoi_gian', $tong_thoi_gian);
    $stmt_sv->bindParam(':id', $sinh_vien_id);
    $stmt_sv->execute();

}


function cap_nhat_thoi_gian_gvnc($giao_vien_id, $con) {
    $query_gvnc = "SELECT SUM(thoi_gian) FROM giao_vien_nghien_cuu WHERE giao_vien_id=:giao_vien_id";

    $stmt_gvnc = $con->prepare($query_gvnc);
    $stmt_gvnc->bindParam(':giao_vien_id', $giao_vien_id);
    $stmt_gvnc->execute();
    $thoi_gian = $stmt_gvnc->fetch(PDO::FETCH_ASSOC);

    $tong_thoi_gian = (int)$thoi_gian['SUM(thoi_gian)'];

    $query_gv = "UPDATE giao_vien SET tong_thoi_gian=:tong_thoi_gian WHERE id=:id";
    $stmt_gv = $con->prepare($query_gv);
    $stmt_gv->bindParam(':tong_thoi_gian', $tong_thoi_gian);
    $stmt_gv->bindParam(':id', $giao_vien_id);
    $stmt_gv->execute();

}

?>
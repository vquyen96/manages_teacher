<?php
// Khai báo các quyền và file được truy cập vào
$middleware = [
    1 => [
        'dashboard' => true,
        'giao_vien' => true,
        'sinh_vien' => true,
        'danh_muc_nghien_cuu' => true,
        'nghien_cuu' => true,
    ],
    2 => [
        'dashboard' => true,
        'giao_vien' => [
            'danhsach.php' => true,
            'xem.php' => true
        ],
        'nghien_cuu' => [
            'danhsach.php' => true,
            'xem.php' => true
        ],
        'tai_khoan' => true,
    ]
];



// Lấy ra các quyền của người dùng
$authRule = $middleware[$auth['phan_quyen']];
// Kiểm tra quyền của người dùng không phù hợp với folder hiện tại thì chuyển trang sang dashboard
if (!isset($authRule[$folder]) || !$authRule[$folder]){
    session_set('error', 'Bạn bị chuyển trang về trang chủ');
    echo '<script type="text/javascript">location.href = "../dashboard/index.php";</script>';
}


// Lấy ra file được truy cập trong folder hiện tại
$authFile = $authRule[$folder];

// Kiểm tra xem hệ thống có phân quyền theo từng file không
if (is_array($authFile)) {
    // Kiểm tra người dùng không có quyền vào file hiện tại thì chuyển trang
    if (!isset($authFile[$file]) || !$authFile[$file]) {
        echo '<script type="text/javascript">location.href = "../dashboard/index.php";</script>';
    }

}


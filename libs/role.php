<?php
// Hàm thiết lập là đã đăng nhập
function set_logged($value){
    session_set('token', $value);
}

// Hàm thiết lập đăng xuất
function set_logout(){
    session_delete('token');
}


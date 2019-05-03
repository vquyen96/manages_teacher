<?php
include '../database.php';
include '../libs/session.php';
include '../libs/checkLogIn.php';

session_delete('token');
header('Location: dangnhap.php');
?>
<?php
    $token = session_get('token');

    if ($token) {
        return header("Location: dashboard/index.php");
    }
?>
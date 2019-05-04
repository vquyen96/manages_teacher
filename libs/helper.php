<?php

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

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

?>
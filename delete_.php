<?php

$id   = $_GET['id'];

//2.DB接続します
require_once('funcs_.php');
$pdo = db_conn();

//3.削除SQLを作成
$stmt = $pdo->prepare('DELETE FROM checkbox_data_table WHERE id = :id');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); //実行


//４．データ登録処理後
if ($status === false) {
    //*** function化する！******\
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    //*** function化する！*****************
    header('Location: index.php');
    exit();
}

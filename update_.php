<?php
require_once('funcs_.php');
$pdo = db_conn();

// echo '<pre>';
// var_dump($_POST);
// echo '</pre>';

$id = $_POST["id"];
$text = $_POST["text"];
$status_emoji = $_POST["status_emoji"];
// 配列で渡されてきた情報で中身がないとkey,value自体存在しないので関数でチェック
$chkbx = check_has_key_in_arr($_POST);

//３．データ登録SQL作成
$stmt = $pdo->prepare('UPDATE checkbox_data_table
                        SET text = :text,
                            chkbx = :chkbx,
                            status_emoji = :status_emoji
                        WHERE id = :id;');

// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':text', $text, PDO::PARAM_STR);
$stmt->bindValue(':chkbx', $chkbx, PDO::PARAM_STR);
$stmt->bindValue(':status_emoji', $status_emoji, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT); //PARAM_INTなので注意

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

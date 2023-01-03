<?php

require_once('funcs_.php');
$pdo = db_conn();

// 配列で渡されてきた情報で中身がないとkey,value自体存在しないので関数でチェック
$chkbx = check_has_key_in_arr($_POST);
$text = $_POST["text"];
$status_emoji = $_POST["status_emoji"];

// echo '<pre>';
// var_dump($_POST);
// echo '</pre>';

//３．データ登録SQL作成
// 1. SQL文を用意
$stmt = $pdo->prepare("INSERT INTO
                        checkbox_data_table
                            (id,    text,  chkbx, status_emoji,  date)
                        VALUES
                            (NULL, :text, :chkbx, :status_emoji,  sysdate())"
);

//  2. バインド変数を用意
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR
// フォームから取得した値（$name、$emailなど）を、「PDO::PARAM_STR」というルールで処理してから「:name」に入れましょう、という指示。：の後はなんでもよく、「:komekomeclub」とかでもOK!
$stmt->bindValue(':text', $text, PDO::PARAM_STR);
$stmt->bindValue(':chkbx', $chkbx, PDO::PARAM_STR);
$stmt->bindValue(':status_emoji', $status_emoji, PDO::PARAM_STR);
//  3. 実行
$status = $stmt->execute();


//４．データ登録処理後
if ($status === false) {
    //SQL実行時にエラーがある場合（エラーオブジェクトを取得して表示）
    $error = $stmt->errorInfo();
    exit('ErrorMessage:' . $error[2]);
} else {
    //５．page00.phpへリダイレクト
    header('Location: end.php');
}

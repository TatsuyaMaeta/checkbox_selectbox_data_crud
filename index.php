<?php
require_once('funcs_.php');
$pdo = db_conn();

$stmt = $pdo->prepare("SELECT * FROM checkbox_data_table;");
$status = $stmt->execute();

$output = "";

$status_emoji_arr = array(
    "emoji_1" => "&#x1F603;",
    "emoji_2" => "&#x1F979;",
    "emoji_3" => "&#x1F607;",
    "emoji_4" => "&#x1F92A;",
    "emoji_5" => "&#x1F61E;"
);

//３．データ表示
if ($status == false) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("ErrorQuery:" . $error[2]);
} else {
    // elseの中はSQLが成功した場合
    //Selectデータの数だけ自動でループしてくれる
    //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
    $table_header = '<table style="border:1px solid; width:250px; text-align:center;" >
                        <tr>
                            <th>id</th>
                            <th>text</th>
                            <th>status</th>
                            <th>edit</th>
                        </tr>';
    $output .= $table_header;

    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $output .= "<tr>
                        <td>{$result['id']}</td>
                        <td>{$result['text']}</td>
                        <td>{$status_emoji_arr[$result["status_emoji"]]}</td>
                        <td><button><a href='detail.php?id={$result['id']}' id='{$result['id']}'>編集</a></button></td>
                    </tr>";
    }
    $output .= "</table>";
}

$progs_array = [
    "js", "php", "html", "css", "python", "dart"
];
$form_checkbox_v = "";
foreach ($progs_array as $v) {
    $form_checkbox_v .= "<label for='{$v}'>
                <input id='{$v}' type='checkbox' name='programming[]' value='{$v}'> {$v}
            </label><br>";
}

// ---------- selectboxの部分 ----------
$select_emoji_dom = "";
// https://gray-code.com/html_css/list-of-emoji/

foreach ($status_emoji_arr as $key => $value) {
    $select_emoji_dom .= "<option value='{$key}'>
                            {$value}
                        </option>";
}
$select_emoji_dom = "<label for='emo'>状態：
                        <select name='emoji' id='emo'>
                            {$select_emoji_dom}
                        </select>
                    </label><br>";

$form_dom_parts_arr = array(
    "head" => "<form action='insert_.php' method='post'>",
    "body_input_text" => "<label for='txt'>
                    テキスト：<input type='text' name='text' id='txt'></label>
                <br>",
    "body_input_checkbox" => $form_checkbox_v,
    "body_input_select" => $select_emoji_dom,
    "body_button" => "<button type='submit'>送信</button>",
    "tail" => "</form>"
);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    foreach ($form_dom_parts_arr as $value) {
        echo $value;
    } ?>
    <hr>
    <h3>登録済み情報</h3>
    <?= $output ?>
</body>

</html>
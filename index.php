<?php
require_once('funcs_.php');
$pdo = db_conn();

// ----------------- checkboxの部分 -----------------
// 入力エリアのDOMをここでループ処理で作る
$progs_array = [
    "js", "php", "html", "css", "python", "dart"
];
$form_checkbox_v = "";
// 配列の数分loopを回してinputタグを作成する
foreach ($progs_array as $v) {
    $form_checkbox_v .= "<label for='{$v}'>
                            <input id='{$v}' type='checkbox' name='programming[]' value='{$v}'> {$v}
                        </label><br>";
}

// ----------------- selectboxの部分 -----------------
// select box用の連想配列
// DBにはこちらのkeyを入れて、表示はvalueを使用する
$status_emoji_arr = array(
    "emoji_1" => "&#x1F603;",   // 😃
    "emoji_2" => "&#x1F979;",   // 🥹
    "emoji_3" => "&#x1F607;",   // 😇
    "emoji_4" => "&#x1F92A;",   // 🤪
    "emoji_5" => "&#x1F61E;"    // 😞

);
$select_emoji_dom = "";
// https://gray-code.com/html_css/list-of-emoji/
foreach ($status_emoji_arr as $key => $value) {
    $select_emoji_dom .= "<option value='{$key}'>
                            {$value}
                        </option>";
}
$select_emoji_dom = "<label for='emo'>状態：
                        <select name='status_emoji' id='emo'>
                            {$select_emoji_dom}
                        </select>
                    </label><br>";

// DBに格納されているデータを取得する
$stmt = $pdo->prepare("SELECT * FROM checkbox_data_table;");
$status = $stmt->execute();

// 最終出力用の変数
$output = "";


//３．データ表示
if ($status == false) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("ErrorQuery:" . $error[2]);
} else {
    // テーブルタグを丸ごと作るのにまず大枠のtableとtrタグの塊を変数に格納
    $table_header = '<table style="border:1px solid; width:250px; text-align:center;" >
                        <tr>
                            <th>id</th>
                            <th>text</th>
                            <th>status</th>
                            <th>edit</th>
                        </tr>';

    // elseの中はSQLが成功した場合
    //Selectデータの数だけ自動でループしてくれる
    //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // $status_emoji_arr用のkeyを変数($emoji_key)に一度入れてからそれを使用してvalueを取り出す
        $emoji_key = $result["status_emoji"];
        $output .= "<tr>
                        <td>{$result['id']}</td>
                        <td>{$result['text']}</td>
                        <td>{$status_emoji_arr[$emoji_key]}</td>
                        <td><button><a href='detail.php?id={$result['id']}' id='{$result['id']}'>編集</a></button></td>
                    </tr>";
    }

    $output = "{$table_header}
                    {$output}
                </table>";
}

// ----------------- 最終出力部分 -----------------
// 最終的に出力するものを1つの配列にまとめる
$form_dom_parts_arr = array(
    "head" => "<form action='insert_.php' method='post'>",
    "body_input_text" => "<label for='txt'>
                    テキスト：<input type='text' name='text' id='txt'></label>
                <br>",
    "body_input_checkbox" => $form_checkbox_v,
    "body_input_select" => $select_emoji_dom,
    "body_submit_button" => "<button type='submit'>送信</button>",
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
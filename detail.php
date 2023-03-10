<?php
$id = $_GET["id"];

//1.  DB接続します
include_once('funcs_.php');
$pdo = db_conn();

$progs_array = [
    "js", "php", "html", "css", "python", "dart"
];
// where のなかにselectboxの選択を定義したものを入れ言え

$status_emoji_arr = array(
    "emoji_1" => "&#x1F603;",
    "emoji_2" => "&#x1F979;",
    "emoji_3" => "&#x1F607;",
    "emoji_4" => "&#x1F92A;",
    "emoji_5" => "&#x1F61E;"
);

$stmt = $pdo->prepare('SELECT * FROM checkbox_data_table WHERE id=:id');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

$output = "";

if (!$status) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("ErrorQuery:" . $error[2]);
} else {
    // データ取得
    $result = $stmt->fetch();
    $text = h($result["text"]);
    $chkbx_ = h($result["chkbx"]);
    $emoji = h($result["status_emoji"]);
    // 文字列を配列に加工
    $chkbx = explode(",", $chkbx_);
    // echo '<pre>';
    // var_dump($emoji);
    // echo '</pre>';

    $output .= "<label for='txt'>
                    テキスト：<input type='text' name='text' id='txt' value='{$text}'>
                </label>
                <br>";

    foreach ($progs_array as $key) {
        // DBから取得したcheckbox一覧の中にあるものとないものを選別
        $has_value = in_array($key, $chkbx);

        // ある場合
        if ($has_value) {
            $output .= "<label for='{$key}'>
                            <input checked id='{$key}' type='checkbox' name='programming[]' value='{$key}'> {$key}
                        </label><br>";
            // ない場合
        } else {
            $output .= "<label for='{$key}'>
                            <input id='{$key}' type='checkbox' name='programming[]' value='{$key}'> {$key}
                        </label><br>";
        }
    }
    // select boxのところでDBに登録されているものを選別する
    $select_emoji_dom = "";
    foreach ($status_emoji_arr as $key_emoji => $value) {
        if ($key_emoji == $emoji) {
            $select_emoji_dom .= "<option value='{$key_emoji}' selected>
                            {$value}
                        </option>";
        } else {
            $select_emoji_dom .= "<option value='{$key_emoji}'>
                            {$value}
                        </option>";
        }
    }
    $select_emoji_dom = "<label for='emo'>状態：
                            <select name='status_emoji' id='emo'>
                                {$select_emoji_dom}
                            </select>
                        </label><br>";
    // 最後にoutputにidとsubmitボタンタグを追加
    $output =   "{$output}
                    {$select_emoji_dom}
                    <input type='text' hidden value='{$id}' name='id'>
                    <button type='submit'>更新</button>";
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit画面</title>
</head>

<body>
    <h2>編集画面</h2>
    <form action="update_.php" method="POST">
        <?= $output ?>
    </form>
    <hr>

    <button><a href="index.php">戻る</a></button>
</body>

</html>
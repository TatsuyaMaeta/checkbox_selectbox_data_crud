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


// 入力エリアのDOMをここでループ処理で作る
$progs_array = [
    "js", "php", "html", "css", "python", "dart"
];
$form_checkbox_v = "<div class='select-wrapper'>";
// 配列の数分loopを回してinputタグを作成する
foreach ($progs_array as $v) {
    $form_checkbox_v .= "
                            <label for='{$v}'>
                                <input id='{$v}' type='checkbox' name='programming[]' value='{$v}'>
                                {$v}
                            </label>";
}
$form_checkbox_v .= "</div>";

// ----------------- selectboxの部分 -----------------
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

// ----------------- DBに登録済みの情報を取得 -----------------
// 2. DBに格納されているデータを取得
$stmt = $pdo->prepare("SELECT * FROM checkbox_data_table;");
$status = $stmt->execute();

// 最終出力用の変数
$output = "";
// 3．データ表示
if (!$status) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("ErrorQuery:" . $error[2]);
} else {
    // テーブルタグを丸ごと作るのにまず大枠のtableとtrタグの塊を変数に格納
    $table_header = '<table class="output-table" >
                        <tr>
                            <th>id</th>
                            <th>text</th>
                            <th>status</th>
                            <th>amount</th>
                            <th>edit</th>
                            <th>delete</th>
                        </tr>';

    // elseの中はSQLが成功した場合
    //Selectデータの数だけ自動でループしてくれる
    //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $chkbx = explode(",", $result["chkbx"]);
        $amount_checkbox = count($chkbx);
        $checkbox_count = 0;

        // 登録されているcheckboxの数が2つ以上の場合
        if ($amount_checkbox > 1) {
            $checkbox_count = $amount_checkbox;

            // 登録されているcheckboxの数が1つの場合
        } elseif ($amount_checkbox == 1 && strlen($chkbx[0]) > 0) {
            $checkbox_count = 1;
            // 登録されているcheckboxの数がない場合
        } else {
            $checkbox_count = 0;
        }

        // $status_emoji_arr用のkeyを変数($emoji_key)に一度入れてからそれを使用してvalueを取り出す
        $emoji_key = $result["status_emoji"];
        $output .= "<tr>
                        <td>{$result['id']}</td>
                        <td>{$result['text']}</td>
                        <td>{$status_emoji_arr[$emoji_key]}</td>
                        <td>{$checkbox_count}コ</td>
                        <td>
                            <button style='width:50px;'>
                                <a href='detail.php?id={$result['id']}'
                                    id='{$result['id']}'
                                    style='text-decoration:none;'>
                                    編集
                                </a>
                            </button>
                        </td>
                        <td>
                            <button class='del_btn' id={$result['id']} style='width:50px;'>
                                    削除
                            </button>
                        </td>
                    </tr>";
    }

    $output = "{$table_header}
                    {$output}
                </table>";
}

// ----------------- 最終出力部分 -----------------
// 最終的に出力するものを1つの配列にまとめる
$form_dom_parts_arr = array(
    "body_input_text" => "<label for='txt'>
                    テキスト：<input type='text' name='text' id='txt'></label>
                <br>",
    "body_input_checkbox" => $form_checkbox_v,
    "body_input_select" => $select_emoji_dom,
    "body_submit_button" => "<button type='submit' class='btn'>送信</button>",
);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index画面</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <form action='insert_.php' method='post'>


        <?php
        foreach ($form_dom_parts_arr as $value) {
            echo $value;
        } ?>
    </form>
    <hr>
    <h3>登録済み情報</h3>
    <?= $output ?>

    <script type="text/javascript">
        // 削除ボタンを押した時にcomfirm画面を出してその内容によって処理を分ける
        const del_btn = document.getElementsByClassName('del_btn');
        // objectを配列に変換
        // https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/Object/entries
        const del_btn_arr = Object.entries(del_btn);
        del_btn_arr.forEach(elm => {
            // console.log(elm);
            // 配列になって帰ってきていて、2つ目に入っているので[1]で指定
            elm[1].addEventListener('click', function() {
                console.log(`id: ` + elm[1].id);
                const result = window.confirm(`id:${elm[1].id}を削除しても良いですか?`);

                if (result) {
                    location.href = `delete_.php?id=${elm[1].id}}`;
                }
            });
        })
    </script>
</body>

</html>
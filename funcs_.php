<?php
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function db_conn()
{
    $db_name    = 'checkbox_data_db';
    $charset    = 'utf8';
    $host       = 'localhost';
    $db_id      = 'root';
    $db_pw      = null;     // MAMPは'root'
    //2. DB接続します（この記述が決まり文句。基本全コピペ。）
    try {
        //まずは接続にチャレンジしてください
        //ID:'root', Password: xamppは 空白 ''（MySQLに入る時には実はIDとパスワードが必要）
        $pdo = new PDO(
            "mysql:dbname={$db_name};
                    charset={$charset};
                    host={$host}",
            $db_id,
            $db_pw
        );

        return $pdo;
    } catch (PDOException $e) {
        //接続でエラーが生じたらこちらに進んでください
        exit('DBConnectError:' . $e->getMessage());
    }
}

function check_has_key_in_arr($post)
{
    // https://uxmilk.jp/13799
    $search = "programming";
    $chkbx = "";

    if (!array_key_exists($search, $post)) {
        // key自体存在しない場合は文字列なしで戻す
        $chkbx  = "";
    } else {
        // 配列の内容を文字列にして戻す
        $prg  = $post[$search];
        $chkbx = implode(",", $prg);
    }
    return $chkbx;
}

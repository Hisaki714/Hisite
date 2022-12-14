<?php

function connect_to_db()
{
     $dbn = 'mysql:dbname=hisite_user;charset=utf8;port=3306;host=localhost';
     $user = 'root';
     $pwd = '';
    try {
        return new PDO($dbn, $user, $pwd);
    } catch (PDOException $e) {
        echo json_encode(["db error" => "{$e->getMessage()}"]);
        exit();
    }
}

function check_session_id()
{
    // 失敗時はログイン画面に戻る
    if (
        !isset($_SESSION['session_id']) ||
        $_SESSION['session_id'] != session_id() 
    ) {
        header('Location: login.php'); 
    } else {
        session_regenerate_id(true); 
        $_SESSION['session_id'] = session_id(); 
    }
}

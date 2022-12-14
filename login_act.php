<?php
// var_dump($_POST);
// exit();
session_start();
include('functions.php');
$pdo = connect_to_db();
$email = $_POST['email']; // データ受け取り変数に入れる
$password = $_POST['password'];
// var_dump($email);
// exit();
// var_dump($password);     
// exit();
$sql = 'SELECT * FROM user WHERE mail_adress=:email	AND password=:password';
// var_dump($sql);
// exit();
//users_tableのmail_addressカラムに今送られてきたemailが入っているか？
//passwordカラムに今送られてきたpasswordが入っているか？をチェックし、
//一致するものがあれば、読みだす

$stmt = $pdo->prepare($sql);
 //var_dump($password);
 //exit();
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$status = $stmt->execute();
// var_dump($status);
// exit();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $val = $stmt->fetch(PDO::FETCH_ASSOC); // 該当レコードを取得し、valという変数に代入
    // var_dump($val);
    // exit();
    if (!$val) { // 該当データがないときはログインページへのリンクを表示
        echo "<p>ログイン情報に誤りがあります．</p>";
        echo '<a href="login.php">ログイン</a>';
        exit();
        //ここから下がSQLが成功したパターンの流れ
    } else {
        $_SESSION = array(); // セッション変数を空にする
        $_SESSION["session_id"] = session_id();
        $_SESSION["nickname"] = $val["nickname"];
        $_SESSION['id'] = $val['id'];
        // var_dump($_SESSION);
        // exit();
        header("Location: index.php"); // 一覧ページへ移動
    }
}

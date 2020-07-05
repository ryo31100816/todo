<?php
session_start();
require_once '../../app/controller/Usercontroller.php';

if(!$logout = filter_input(INPUT_POST,'logout')){
    exit('不正なリクエストです');
}

$result = Usercontroller::checkLogin();

if(!$result){
    exit('セッションが切れたのでログインし直してください');
}

Usercontroller::logout();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログアウト</title>
</head>
<body>
    <h2>ログアウト完了</h2>
<p>ログアウト完了</p>
<a href="login_form.php">ログイン画面へ<a>
</body>
</html>
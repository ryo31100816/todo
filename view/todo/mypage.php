<?php
session_start();
require_once '../../app/controller/Usercontroller.php';
require_once 'function.php';

$result = Usercontroller::checkLogin();

if(!$result){
    $_SESSION['login_err'] = 'ユーザー登録をしてログインしてください。';
    header('Location: signup_form.php');
    return;
}

$login_user = $_SESSION['login_user'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ</title>
</head>
<body>
    <h2>マイページ</h2>
    <p>ログインユーザ:<?php echo h($login_user['username']) ?></p>
    <p>メールアドレス:<?php echo h($login_user['email']) ?></p>
    <form action="logout.php" method="post">
    <input type="submit" name="logout" value="ログアウト">
    </form>
</body>
</html>
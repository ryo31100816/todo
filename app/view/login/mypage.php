<?php
session_start();
require_once '../../controller/LoginController.php';

$result = LoginController::checkLogin();
if(!$result){
    $_SESSION['error_msgs'] = 'ユーザー登録をしてログインしてください。';
    header('Location: signup_form.php');
    return;
}

if(filter_input(INPUT_POST,'logout')){
    LoginController::logout();
    header('Location: login_form.php');
    return;
}

$login_user = $_SESSION['login_user'];
$username = LoginController::escape($login_user['username']);
$email = LoginController::escape($login_user['email']);

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/css/stylesheet.css">
        <title>My Page</title>
    </head>
<body>
<div class="wrapper-container">
    <div class="title">My Page</div>
    <p>User:<?php echo $username ?></p>
    <p>E-mail:<?php echo $email ?></p>
    <form method="POST" action="mypage.php">
    <input type="submit" name="logout" value="Logout">
    </form>
</div>
</body>
</html>
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
    <div class="showboard">
        <div class="board-contents">
        <p>User:</p>
        <p class="board-contents border-btm"><?php echo $username ?></p>
        </div>
        <div class="board-contents">
        <p>E-mail:</p>
        <p class="board-contents border-btm"><?php echo $email ?></p>
        </div>
        <form method="POST" action="mypage.php">
            <button class="btn" type="submit" name="logout" value="logout">
            <div class="check">&check;</div>
            <div class="word">Logout</div>
            </button>
        </form>
    </div>
    <a class="link" href="../todo/index.php">Todo Index</a>
</div>
</body>
</html>
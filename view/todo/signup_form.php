<?php
session_start();
require_once '../../app/controller/Usercontroller.php';
require_once 'function.php';

$result = Usercontroller::checkLogin();

if($result){
    header('Location: mypage.php');
    return;
}

$login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;
unset($_SESSION['login_err']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>ユーザーフォーム</h2>
    <?php  if(isset($login_err)):?>
        <p><?php echo $login_err ;?></p>
    <?php endif; ?>
    <form action="register.php" method="POST">
    <p>
    <lablel for="username">ユーザー名:</lable>
    <input type="text" name="username">
    </p>
    <p>
    <lablel for="email">E-mail</lable>
    <input type="email" name="email">
    </p>
    <p>
    <lablel for="password">パスワード</lable>
    <input type="password" name="password">
    </p>
    <p>
    <p>
    <lablel for="password">パスワード確認</lable>
    <input type="password" name="password_conf">
    </p>
    <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>"
    <p>
    <input type="submit" value="sinup">
    </p>
    </form>
    <a href="login_form.php">ログイン</a>
</body>
</html>
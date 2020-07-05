<?php

session_start();

require_once '../../app/controller/Usercontroller.php';

$result = Usercontroller::checkLogin();

if($result){
    header('Location: mypage.php');
    return;
}

$error = $_SESSION;

$_SESSION = array();
session_destroy();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
</head>
<body>
    <h2>ログインフォーム</h2>
    <?php  if(isset($error['msg'])):?>
        <p><?php echo $error['msg'];?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
    <p>
    <lablel for="email">E-mail</lable>
    <input type="email" name="email">
    <?php  if(isset($error['email'])):?>
        <p><?php echo $error['email'];?></p>
    <?php endif; ?>
    </p>
    <p>
    <lablel for="password">パスワード</lable>
    <input type="password" name="password">
    <?php  if(isset($error['password'])):?>
        <p><?php echo $error['password'];?></p>
    <?php endif; ?>
    </p>
    <p>
    <p>
    <input type="submit" value="ログイン">
    </p>
    </form>
    <a href="signup_form.php">新規登録はこちら</a>
</body>
</html>
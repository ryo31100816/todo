<?php
require_once '../../app/controller/Usercontroller.php';

session_start();
$token = filter_input(INPUT_POST,'csrf_token');
if(!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']){
    exit('不正なリクエストです。');
}
unset($_SESSION['csrf_token']);

$error= [];
$action = new Usercontroller();
$result = $action->register();
if(!$result){
    $error[] = '登録に失敗しました。';
}
unset($_SESSION['pre_user']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/css/stylesheet-new.css">
        <title>Complete</title>
    </head>
<body>
<div class="wrapper-container">
    <?php if(count($error) > 0) : ?>
        <?php foreach($error as $e) : ?>
        <p><?php echo $e ?></p>
        <? endforeach ?>
        <a href="../login/signup_form.php">Signup</a>
    <?php else : ?>
        <div class="title">Complete</div>
        <p>ユーザー登録が完了しました。</p>
        <a href="../login/login_form.php">To Login</a>
    <?php endif ?>
</div>
</body>
</html>
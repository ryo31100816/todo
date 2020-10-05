<?php
session_start();
require_once (__DIR__.'/../../controller/UserController.php');

$token = filter_input(INPUT_POST,'csrf_token');
if(!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']){
    exit('不正なリクエストです。');
}
unset($_SESSION['csrf_token']);

$error= [];
$action = new UserController();
$result = $action->preRegister();
if(!$result){
    $error[] = 'メール送信に失敗しました。';
}

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/css/stylesheet.css">
        <title>Result</title>
    </head>
<body>
<div class="wrapper-container">
    <?php if(count($error) > 0) : ?>
        <?php foreach($error as $e) : ?>
        <p><?php echo $e ?></p>
        <? endforeach ?>
    <?php else : ?>
        <div class="title">Complete</div>
        <p>メールを送信しました。</p>
    <?php endif ?>
    <a href="../login/pre_signup_form.php">Signup</a>
</div>
</body>
</html>
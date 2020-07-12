<?php

session_start();
require_once '../../app/controller/Usercontroller.php';

// $action = new Usercontroller();
// $user = $action->register($_POST);

$error= [];
$token = filter_input(INPUT_POST,'csrf_token');
if(!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']){
    exit('不正なリクエスト');
}
unset($_SESSION['csrf_token']);

if(!$username = filter_input(INPUT_POST,'username')){
    $error[] = 'ユーザー名を入力してください。';
}
if(!$email = filter_input(INPUT_POST,'email')){
    $error[] = 'メールアドレスを入力してください。';
}
$password = filter_input(INPUT_POST,'password');
if(!preg_match("/\A[a-z\d]{8,20}+\z/i",$password)){
    $error[] = 'パスワードは英数字8文字以上20文字以下にしてください。';
}
$password_conf = filter_input(INPUT_POST,'password_conf');
if($password !== $password_conf){
        $error[] = '確認用パスワードと異なります。';
}
if(count($error) === 0){
    $created = Usercontroller::register($_POST);
    if($created){
        $error[] = '登録に失敗しました。';
    }
}

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
            <a href="signup_form.php">Signup</a>
        <?php else : ?>
            <div class="title">Complete</div>
            <p>ユーザー登録が完了しました。</p>
            <a href="./login_form.php">To Login</a>
        <?php endif ?>
    </div>
</body>
</html>
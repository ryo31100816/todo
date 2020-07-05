<?php

require_once '../../app/controller/Usercontroller.php';


// $action = new Usercontroller();
// $user = $action->register($_POST);
session_start();

$error= [];


if(!$email = filter_input(INPUT_POST,'email')){
    $error['email'] = 'メールアドレスを入力してください。';
}
if(!$password = filter_input(INPUT_POST,'password')){
    $error['password'] = 'パスワードを入力してください。';
};


if(count($error) > 0){
    $_SESSION = $error;
    header('Location: login_form.php');
    return;
}

$result = Usercontroller::login($email,$password);

if(!$result){
    header('Location:login_form.php');
    return;
}





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン完了</title>
</head>
<body>
<h2>ログイン完了</h2>
<?php if(count($error) > 0) : ?>
    <?php foreach($error as $e) : ?>
    <p><?php echo $e ?></p>
    <? endforeach ?>
<?php else : ?>
    <p>ログインしました。</p>
<?php endif ?>
    <a href="mypage.php">マイページへ戻る</a>

</body>
</html>
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
    header('Location: login.php');
    return;
}

$result = Usercontroller::login($email,$password);

if(!$result){
    header('Location:login.php');
    return;
}

echo 'ログイン成功です。';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録完了</title>
</head>
<body>
<?php if(count($error) > 0) : ?>
    <?php foreach($error as $e) : ?>
    <p><?php echo $e ?></p>
    <? endforeach ?>
<?php else : ?>
    <p>ユーザー登録が完了しました。</p>
<?php endif ?>
    <a href="login.php">戻る</a>

</body>
</html>
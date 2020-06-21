<?php

require_once '../../app/controller/Usercontroller.php';


// $action = new Usercontroller();
// $user = $action->register($_POST);



$error= [];

if(!$username = filter_input(INPUT_POST,'username')){
    $error[] = 'ユーザー名を入力してください。';
}
if(!$email = filter_input(INPUT_POST,'email')){
    $error[] = 'メールアドレスを入力してください。';
}
$password = filter_input(INPUT_POST,'password');
if(!preg_match("/\A[a-z\d]{8,100}+\z/i",$password)){
    $error[] = 'パスワードは英数字8文字以上100文字以下にしてください。';
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
    <a href="./signup_form.php">戻る</a>

</body>
</html>
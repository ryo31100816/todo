<?php
session_start();
require_once '../../app/controller/Usercontroller.php';

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $action = Usercontroller::login($_POST['email'],$_POST['password']);
    // $action->login($_POST['email'],$_POST['password']); 
}
if($action === true){
    header('Location: index.php');
    return;
}
$login_user = $_SESSION['login_user'];
$username = Usercontroller::h($login_user['username']);
$email = Usercontroller::h($login_user['email']);

$result = Usercontroller::checkLogin();
if(!$result){
    $_SESSION['login_err'] = 'ユーザー登録をしてログインしてください。';
    header('Location: signup_form.php');
    return;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/stylesheet-new.css">
    <title>My Page</title>
</head>
<body>
    <div class="wrapper-container">
    <div class="title">My Page</div>
        <p>User:<?php echo $username ?></p>
        <p>E-mail:<?php echo $email ?></p>
        <form action="logout.php" method="post">
        <input type="submit" name="logout" value="Logout">
        </form>
    </div>
</body>
</html>
<?php
session_start();
require_once '../../app/controller/Usercontroller.php';

$token = filter_input(INPUT_GET,'token');
if(isset($token)){
    $action = new Usercontroller();
    $result = $action->checkpreRegist();
}else{
    exit('不正なリクエストです。');
}
if(!$result){
    foreach( $_SESSION['error_msgs'] as $error_msg){
        echo $error_msg.PHP_EOL;
    }
    unset($_SESSION['error_msgs']);
    exit();
}

$csrf_token = Usercontroller::escape( Usercontroller::setToken());

$login_status = Usercontroller::checkLogin();
if($login_status){
    header('Location: mypage.php');
    return;
}

$error_msgs = isset($_SESSION['error_msgs']) ? $_SESSION['error_msgs'] : null;
unset($_SESSION['error_msgs']);
 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/css/stylesheet-new.css">
        <title>Signup Form</title>
    </head>
<body>
<div class="wrapper-container">
    <div class="title">Signup</div>
    <?php  if(isset($error_msgs)):?>
        <?php foreach($error_msgs as $error_msg) :?>
            <p><?php echo $error_msg ;?></p>
        <?php endforeach ;?>
    <?php endif; ?>
    <form class="showboard" action="../user/register.php" method="POST">
        <div  class="board-contents"> 
            <label for="username"><div>User</div></label>
            <div>
            <input id="username" class= "board-item" type="text" name="username">
            </div>
        </div>
        <div  class="board-contents"> 
            <label for="password"><div>Password</div></label>
            <div>
            <input id="password" class= "board-item" type="password" name="password">
            </div>
        </div>
        <div  class="board-contents">
            <label for="password-c"><div>Password Check</div></label>
            <div>
            <input id="password-c" class= "board-item" type="password" name="password_conf">
            </div>
        </div>
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        <p><input type="submit" value="sinup"></p>
    </form>
    <a href="./login_form.php">Login</a>
</div>
</body>
</html>
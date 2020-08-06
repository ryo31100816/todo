<?php
session_start();
require_once '../../app/controller/Usercontroller.php';

$csrf_token = Usercontroller::escape(Usercontroller::setToken());

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
        <title>pre Signup Form</title>
    </head>
<body>
<div class="wrapper-container">
    <div class="title">Pre Signup</div>
    <?php  if(isset($error_msgs)):?>
        <?php foreach($error_msgs as $error_msg) :?>
            <p><?php echo $error_msg ;?></p>
        <?php endforeach ;?>
    <?php endif; ?>
    <form class="showboard" action="../user/pre_register.php" method="POST">
        <div  class="board-contents"> 
            <label for="email"><div>E-mail</div></label>
            <div>
            <input id="email" class= "board-item" type="email" name="email">
            </div>
        </div>
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        <p><input type="submit" value="sinup"></p>
    </form>
    <a href="./login_form.php">Login</a>
</div>
</body>
</html>
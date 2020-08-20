<?php
session_start();
require_once '../../controller/LoginController.php';


if($_SERVER["REQUEST_METHOD"] === "POST"){
    $action = LoginController::login();
    if($action === true){
        header('Location: ../todo/index.php');
    }
   return;
}

$error_msgs = $_SESSION['error_msgs'];
unset($_SESSION['error_msgs']);

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/css/stylesheet-new.css">
        <title>Login Form</title>
    </head>
<body>
<div class="wrapper-container">
    <div class="title">Login</div>
    <form class="showboard" method="POST" action="login_form.php">
        <div  class="board-contents"> 
            <div>E-mail</div>
            <div>
            <input class= "board-item" type="email" name="email">
            </div>
            <?php  if(isset($error_msgs['email'])):?>
                <p><?php echo $error_msgs['email'];?></p>
            <?php endif; ?>
        </div>
        <div  class="board-contents"> 
            <div>Password</div>
            <input class= "board-item" type="password" name="password">
            <?php  if(isset($error_msgs['password'])):?>
                <p><?php echo $error_msgs['password'];?></p>
            <?php endif; ?>
        </div>
        <input type="submit" value="Login">
    </form>
    <a href="./pre_signup_form.php">Pre Signup</a>
</div>
</body>
</html>
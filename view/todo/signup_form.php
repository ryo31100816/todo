<?php
session_start();
require_once '../../app/controller/Usercontroller.php';

$csrf_token = Usercontroller::h( Usercontroller::setToken());

$result = Usercontroller::checkLogin();

if($result){
    header('Location: mypage.php');
    return;
}

$login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;
unset($_SESSION['login_err']);
 
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
    <?php  if(isset($login_err)):?>
        <p><?php echo $login_err ;?></p>
    <?php endif; ?>
    <div class="wrapper-container">
    <div class="title">Signup</div>
        <form class="showboard" action="register.php" method="POST">
            <div  class="board-contents"> 
                <label for="username"><div>User</div></label>
                <div>
                <input id="username" class= "board-item" type="text" name="username">
                </div>
            </div>
            <div  class="board-contents"> 
                <label for="email"><div>E-mail</div></label>
                <div>
                <input id="email" class= "board-item" type="email" name="email">
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
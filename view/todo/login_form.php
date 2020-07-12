<?php
// session_cache_limiter('private_no_expire');

require_once '../../app/controller/Usercontroller.php';
session_start();
$error_msgs = $_SESSION['error_msgs'];
unset($_SESSION['error_msgs']);

// $login_check = Usercontroller::checkLogin();
// if($login_check){
//     header('Location: mypage.php');
//     return;
// }
$error= [];
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $action = new Usercontroller;
    $action->login($_POST['email'],$_POST['password']); 
}


// if(!empty($_POST['email']) && !empty($_POST['password'])){
//     $action = new Usercontroller;
//     $action->login($_POST['email'],$_POST['password']); 
// }

// if(!$email = filter_input(INPUT_POST,'email')){
//     $error['email'] = 'メールアドレスを入力してください。';
// }
// if(!$password = filter_input(INPUT_POST,'password')){
//     $error['password'] = 'パスワードを入力してください。';
// }
// var_dump(!empty($_POST['email']) && !empty($_POST['password']));
// var_dump(em($_POST['email']) && isset($_POST['password']));
// var_dump($error);

// if(count($error) > 0){
//     header('Location: login_form.php');
//     return;
// }
// if(isset($_POST['email']) && isset($_POST['password'])){
//     $result = Usercontroller::login($email,$password);
// }
// if(!$result){
//     header('Location:login_form.php');
//     return;
// }

// if($result){
//     header('Location: mypage.php');
//     return;
// }

?>

<!DOCTYPE html>
<html lang="en">
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
    <form class="showboard" action="mypage.php" method="POST">
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
        </p>
    </form>
    <a href="./signup_form.php">Signup</a>
    </div>
</body>
</html>
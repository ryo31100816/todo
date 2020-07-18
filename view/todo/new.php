<?php
require_once '../../app/controller/Todocontroller.php';

session_start();
$user_id = $_SESSION['login_user']['user_id'];
$error_msgs = $_SESSION['error_msgs'];
unset($_SESSION["error_msgs"]);

$login_status = Todocontroller::is_login($user_id);
if(!$login_status){
    header("Location: login_form.php");
    return;
}

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = new Todocontroller;
    $action->new(); 
}

if($_SERVER["REQUEST_METHOD"] === "GET") {
    if(isset($_GET['title'])) {
        $title = $_GET['title'];
    }
    if(isset($_GET['detail'])) {
        $detail = $_GET['detail'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>NEW</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/css/stylesheet-new.css">
    </head>
<body>
    <?php if($error_msgs):?>
    <div>
        <ul>
        <?php foreach($error_msgs as $error_msg):?>
            <li><?php echo $error_msg; ?></li>
        <?php endforeach;?>
        </ul>
    </div>
    <?php endif;?>
<div class="wrapper-container">
    <div class="title">New TODO</div>
    <form class="showboard" method="POST" action="./new.php">
    <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
        <div  class="board-contents"> 
            <div>Title</div>
            <div>
            <input class= "board-item" name="title" type="text" value="<?php echo $title;?>">
            </div>
        </div>
        <div  class="board-contents">
            <div>Detail</div>
            <div>
            <textarea class="board-item" name="detail"><?php echo $detail;?></textarea>
            </div>
        </div>
        <button class="new-btn" type="submit"><i class="fas fa-plus"></i>Add</button>
    </form>
</div>
</body>
</html>














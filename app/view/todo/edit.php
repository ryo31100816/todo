<?php
session_start();
require_once (__DIR__.'/../../config/database.php');
require_once (__DIR__.'/../../model/Todo.php');
require_once (__DIR__.'/../../controller/TodoController.php');

$action = new TodoController();
$todo = $action->edit();

$error_msgs = $_SESSION['error_msgs'];
unset($_SESSION["error_msgs"]);

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>Edit</title>
        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/css/stylesheet.css">
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
    <div class="title">Edit</div>
    <form class="showboard" method="POST" action="./edit.php">
    <input type="hidden" name="todo_id" value="<?php echo $_GET['todo_id'];?>">
        <div  class="board-contents"> 
            <div>Title:</div>
            <div>
            <input class="board-item" name="title" type="text" value="<?php echo $todo['title'];?>">
            </div>
        </div>
        <div  class="board-contents"> 
            <div>Detail:</div>
            <div>
            <textarea class="board-item" name="detail"><?php echo $todo['detail'];?></textarea>
            </div>
        </div>
        <button class="btn" type="submit">
        <div class="check">&check;</div>
        <div class="word">OK</div>
        </button>
    </form>
    <a class="link" href="./detail.php?todo_id=<?php echo $todo['id'];?>">Detail</a>
</div>
</div>
</body>
</html>
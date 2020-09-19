<?php
session_start();
require_once '../../config/database.php';
require_once '../../model/Todo.php';
require_once '../../controller/TodoController.php';

$action = new TodoController();
$todo = $action->detail();

 ?>

<!DOCTYPE html>
 <html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Detail</title>
        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/css/stylesheet.css">
    </head>
<body>
<div class="wrapper-container">
    <div class="title">Detail</div>
    <form class="showboard" method="POST" action="./edit.php">
    <input type="hidden" name="todo_id" value="<?php echo $todo['id'];?>">
        <div  class="board-contents"> 
            <div>Title:</div>
            <div>
            <p class="board-item border-btm"><?php echo $todo["title"];?></p>
            </div>
        </div>
        <div  class="board-contents"> 
            <div>Detail:</div>
            <div>       
            <p class="board-item border-btm"><?php echo $todo["detail"];?></p>
            </div>
        </div>
        <a href="./edit.php?todo_id=<?php echo $todo['id'];?>">
        <div class="edit icon"></div>
        <p class="word link">Edit</p>
        </a>
    </form>
    <a class="link" href="./index.php">Todo Index</a>
</div>
</body>
</html>
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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/css/stylesheet-new.css">
    </head>
<body>
<div class="wrapper-container">
    <div class="title">Detail</div>
    <form class="showboard" method="POST" action="./edit.php">
    <input type="hidden" name="todo_id" value="<?php echo $todo['id'];?>">
        <div  class="board-contents"> 
            <div>Title</div>
            <div>
                <a class="board-item"><?php echo $todo["title"];?></a>
            </div>
        </div>
        <div  class="board-contents"> 
            <div>Detail</div>
            <div>       
                <a class="board-item"><?php echo $todo["detail"];?></a>
            </div>
        </div>    
        <button type="submit"><a href="./edit.php?todo_id=<?php echo $todo['id'];?>"> To Edit</a></button>      
    </form>
</div>  
</body>
</html>
<?php
 require_once '../../app/config/database.php';
 require_once '../../app/model/Todo.php';
 require_once '../../app/controller/Todocontroller.php';
 
 $action = new Todocontroller();
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
        <link rel="stylesheet" href="/css/stylesheet-new.css">
    </head>
    <body>

    <div class="new-register">
    <div class="title">Detail</div>
        <div  class="form-contents"> 
            <div>Title</div>
            <div>
            <a class="form-item"><?php echo $todo["title"];?></a>
            </div>
        </div>
        <div  class="form-contents"> 
            <div>Detail</div>
            <div>       
            <a class="form-item"><?php echo $todo["detail"];?></a>
            </div>
        </div>
    </div>
        <div>
        <form action="./edit.php" method="post">
            <input type="hidden" name="todo_id" value="<?php echo $todo['id'];?>">
            <button type="submit">
            <a href="./edit.php?todo_id=<?php echo $todo['id'];?>">Edit</a>
            </button>      
        </form>      
        </div>
    </body>
</html
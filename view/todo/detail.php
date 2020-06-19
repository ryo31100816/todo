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
        <title>詳細画面</title>
    </head>
    <body>
        <table class="table">
            <thead>
                <tr>
                <th>タイトル</th>
                    <th>詳細</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope="row"><?php echo $todo["title"];?></td>
                    <td><?php echo $todo["detail"];?></td>
                </tr>
                <tr>
                    <td scope="row"></td>
                    <td></td>
                <td></td>
                </tr>
            </tbody>
        </table>
        <div>
        <form action="./edit.php" method="post">
            <input type="hidden" name="todo_id" value="<?php echo $todo['id'];?>">
            <button type="submit">
            <a href="./edit.php?todo_id=<?php echo $todo['id'];?>">編集</a>
            </button>      
        </form>      
        </div>
    </body>
</html
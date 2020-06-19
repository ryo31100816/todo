<?php

require_once('../../app/model/Todo.php');
require_once('../../app/controller/Todocontroller.php');

// $query="SELECT * FROM todos";
// $todo_list = Todo::findAll();

try {
    $dbh = new PDO(DSN, USER, PASSWORD);
} catch (PDOException $e) {
    echo 'データベースにアクセスできません！' . $e->getMessage();
    exit;
}
     
if(isset($_GET['action']) & $_GET['action'] === 'delete') {
    $action = new Todocontroller;
    $todo_list = $action->delete();
}

$controller = new TodoController();
$todo_list = $controller->index();


?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>TODOリスト</title>
        <link rel="stylesheet" href="/css/stylesheet.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    </head>
  <body>
<div class="wrapper-container">
    <div id="nav">
        <!-- <div class="menu-container"> -->
            <a href="./new.php" class="btn">NEW</a>
        <!-- </div> -->
    </div>
    <?php if($todo_list):?>
    <div class="task-container">
        <ul>
            <?php foreach($todo_list as $todo):?>
                <div class="task">
                    <a href="./detail.php?todo_id=<?php echo $todo['id'];?>" class="item">
                        <?php echo $todo['title'];?>
                    </a>
                    <a class="delete_btn" data-id="<?php echo $todo['id'];?>">
                        Del
                    </a>
                </div>
            <?php endforeach;?>
        </ul>
        <?php else:?>
            <div>データがありません</div>
    </div>
        <?php endif;?>
</div>    
 </body>
</html>
<script>
 $(".delete_btn").click(function() {
    const todo_id = $(this).data('id');
    alert("削除します");
    // alert(todo_id);
    window.location.href = "./index.php?action=delete&todo_id=" + todo_id;
 });
</script>

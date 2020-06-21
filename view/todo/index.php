<?php
ini_set('log_errors','on');
ini_set('error_log','/log/php_error.log');
// require_once('../../app/model/Todo.php');
require_once('../../app/controller/Todocontroller.php');

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
                    <a class="item" href="./detail.php?todo_id=<?php echo $todo['id'];?>">
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
 <script type="text/javascript" src="/js/script.js?date=20190401"></script>
</html>


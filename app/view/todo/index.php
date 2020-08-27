<?php
session_start();
require_once '../../controller/TodoController.php';

try {
    $dbh = new PDO(DSN, USER, PASSWORD);
} catch (PDOException $e) {
    echo 'データベースにアクセスできません！' . $e->getMessage();
    exit;
}
     
if(isset($_GET['action']) & $_GET['action'] === 'delete') {
    $action = new TodoController;
    $todo_list = $aCtion->delete();
}

if(isset($_GET['action']) & $_GET['action'] === 'complete') {
    $action = new TodoController;
    $todo_list = $action->complete();
}

$controller = new TodoController();
$username = $_SESSION['login_user']['username'];
$user_id = $_SESSION['login_user']['user_id'];
$todo_list = $controller->index();

if(isset($_SESSION['success_msg'])){
    $success_msg = $_SESSION['success_msg'];
    unset($_SESSION['success_msg']);
}

?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>TODO index</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/css/stylesheet-index.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    </head>
<body>
<div class="wrapper-container">
    <div id="nav" class="navbar">
        <div><a href="../login/mypage.php" class="login-user"><?php echo $username; ?></a></div>
        <div><a href="./new.php" class="btn new-btn">NEW</a></div>
        <div>
        <form id="csv" method="POST">
        <input type="hidden" name="userid" value="<?php echo $user_id;?>">
        <input type="hidden" name="csv-action" value="csv-action">
        <button id="request" class="btn" type="submit">CSV</button>
        </form>
        </div>
        <form class="search-form" method="GET" action="index.php">
            <input class="search-item" type="text" name="word">
            <input type="radio" name="completed_at" value="NOT NULL">完了
            <input type="radio" name="completed_at" value="NULL" checked>未完了
            <input type="submit" name="search" value="Search">
        </form>
    </div>
    <?php if($todo_list):?>
    <div class="task-container">
        <div id="complete" class="complete hide">
        <input id="success-msg" type="hidden" value="<?php echo $success_msg;?>">
        <p class="task"><?php echo $success_msg; ?></p>
        </div>
        <ul>
            <?php foreach($todo_list as $todo):?>
                <div class="task">
                    <a class="task-item" href="./detail.php?todo_id=<?php echo $todo['id'];?>">
                        <?php echo $todo['title'];?>
                    </a>

                    <a class="complete-btn" data-id="<?php echo $todo['id'];?>">
                        <i class="far fa-check-square"></i>
                    </a>
                    <a class="delete-btn" data-id="<?php echo $todo['id'];?>">
                        <i class="far fa-trash-alt"></i>
                    </a>
                    <a class="complete-status" value="<?php echo $todo['completed_at'] ;?>"></a>
                </div>
            <?php endforeach;?>
        </ul>
    <?php else:?>
        <div>データがありません</div>
    </div>
    <?php endif;?>
</div>    
</body>
<script type="text/javascript" src="/js/script.js"></script>
<script type="text/javascript" src="/js/ajax_csv.js"></script>
</html>

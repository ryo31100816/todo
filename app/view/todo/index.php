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
    $todo_list = $action->delete();
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
        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/css/stylesheet-index.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    </head>
<body>
<div class="wrapper-container">
    <nav class="navbar">
        <a href="../login/mypage.php" class="login-user"><?php echo $username; ?></a>
        <a href="./new.php" class="btn">NEW</a>
        <form id="csv" method="POST">
            <input type="hidden" name="userid" value="<?php echo $user_id;?>">
            <input type="hidden" name="csv-action" value="csv-action">
            <button id="request" class="btn" type="submit">CSV</button>
        </form>
        <a href="./download_csv.php" id="dl-btn" class="btn hide">Download</a>
        <form class="search-form" method="GET" action="index.php">
            <input class="search-input" type="text" name="word">
            <button class="search-btn" type="submit" name="search"></button>
            <input type="radio" name="status" value="1">完了
            <input type="radio" name="status" value="0" checked>未完了
        </form>
    </nav>
    <?php if($todo_list):?>
        <div class="task-container">
            <div id="complete" class="complete hide">
                <input id="success-msg" type="hidden" value="<?php echo $success_msg;?>">
                <p class="task"><?php echo $success_msg; ?></p>
            </div>
            <ul>
            <?php foreach($todo_list as $todo):?>
                <div class="task">
                    <a class="complete-btn" data-id="<?php echo $todo['id'];?>"></a>
                    <a class="complete-status" value="<?php echo $todo['status'] ;?>"></a>
                    <a class="task-item" href="./detail.php?todo_id=<?php echo $todo['id'];?>">
                    <?php echo $todo['title'];?>
                    </a>
                    <a class="delete-btn trash" data-id="<?php echo $todo['id'];?>"></a>
                </div>
            <?php endforeach;?>
            </ul>
        </div>
    <?php else:?>
        <div>データがありません</div>
    <?php endif;?>
</div>
<script type="text/javascript" src="/js/script.js"></script>
<script type="text/javascript" src="/js/ajax_csv.js"></script>
</body>
</html>

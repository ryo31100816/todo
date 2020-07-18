<?php
ini_set('log_errors','on');
ini_set('error_log','/log/php_error.log');
require_once '../../app/controller/Todocontroller.php';

try {
    $dbh = new PDO(DSN, USER, PASSWORD);
} catch (PDOException $e) {
    echo 'データベースにアクセスできません！' . $e->getMessage();
    exit;
}

session_start();
$username = $_SESSION['login_user']['username'];
$user_id = $_SESSION['login_user']['user_id'];

$login_status = Todocontroller::is_login($user_id);
if(!$login_status){
    header("Location: login_form.php");
    return;
}

$from_new ='';
if($_SERVER['HTTP_REFERER'] === "http://127.0.0.1:8000/view/todo/new.php"){
    $from_new = 'from-new';
}
     
if(isset($_GET['action']) & $_GET['action'] === 'delete') {
    $action = new Todocontroller;
    $todo_list = $action->delete();
}

$controller = new TodoController();
$todo_list = $controller->index($user_id);

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
        <div><a href="./mypage.php" class="login-user"><?php echo $username; ?></a></div>
        <div><a href="./new.php" class="btn new-btn">NEW</a></div>
        <div>
        <form method="POST" action="output_csv.php">
        <button class="btn" type="submit" name="dlbtn" value="CSV">CSV</buttom>
        </form>
        </div>
    </div>
    <?php if($todo_list):?>
    <div class="task-container">
        <div id="complete" class="complete hide">
        <input id="from-new" type="hidden" value="<?php echo $from_new;?>">
        <p>登録しました</p>
        </div>
        <ul>
            <?php foreach($todo_list as $todo):?>
                <div class="task">
                    <a class="task-item" href="./detail.php?todo_id=<?php echo $todo['id'];?>">
                        <?php echo $todo['title'];?>
                    </a>
                    <a class="delete-btn" data-id="<?php echo $todo['id'];?>">
                        <i class="far fa-trash-alt"></i>
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


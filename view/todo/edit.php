<?php
 require_once '../../app/config/database.php';
 require_once '../../app/model/Todo.php';
 require_once '../../app/controller/Todocontroller.php';

//  $_SESSION['todo_id'] = $_POST['todo_id'];
//  var_dump($_SESSION);
//  exit;

 $action = new Todocontroller();
 $todo = $action->edit();

session_start();
// セッション情報の取得
$error_msgs = $_SESSION['error_msgs'];

//セッション削除
unset($_SESSION["error_msgs"]);


?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>編集</title>
    </head>
<body>
    <div>編集</div>
    <form action="./edit.php" method="post">
    <input type="hidden" name="todo_id" value="<?php echo $_GET['todo_id'];?>">
        <div>
            <div>タイトル</div>
            <div>
                <input name="title" type="text" 
                value="<?php echo $todo['title'];?>">
            </div>
        </div>
        <div>
            <div>詳細</div>
            <div>
                <textarea name="detail"><?php echo $todo['detail'];?></textarea>
            </div>
        </div>
        <button type="submit">登録</button>
    </form>
    <?php if($error_msgs):?>
        <div>
            <ul>
                <?php foreach($error_msgs as $error_msg):?>
                <li><?php echo $error_msg; ?></li>
                <?php endforeach;?>
            </ul>
        </div>
    <?php endif;?>
</body>
</html
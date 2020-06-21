<?php

ini_set('log_errors','on');
ini_set('error_log','/log/php_error.log');
require_once '../../app/controller/Todocontroller.php';

session_start();
// セッション情報の取得
$error_msgs = $_SESSION['error_msgs'];
//セッション削除
unset($_SESSION["error_msgs"]);

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = new Todocontroller;
    $action->new(); 
}


if($_SERVER["REQUEST_METHOD"] === "GET") {
    if(isset($_GET['title'])) {
        $title = $_GET['title'];
    }
    if(isset($_GET['detail'])) {
        $detail = $_GET['detail'];
    }
}

?>

<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>NEW</title>
        </head>
        <body>
        
                        <?php if($error_msgs):?>
                            <div>
                                 <ul>
                                    <?php foreach($error_msgs as $error_msg):?>
                                        <li><?php echo $error_msg; ?></li>
                                    <?php endforeach;?>
                                 </ul>
                            </div>
                        <?php endif;?>

            <div>New TODO</div>
                <form action="./new.php" method="post">
                    <div>
                        <div>Title</div>
                        <div>
                            <input name="title" type="text" value="<?php echo $title;?>">
                        </div>
                    </div>
                    <div>
                        <div>Detail</div>
                        <div>
                            <textarea name="detail"><?php echo $detail;?></textarea>
                        </div>
                    </div>
                        <button type="submit">登録</button>
                </form>
        </body>
    </html>














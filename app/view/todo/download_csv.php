<?php
session_start();
require_once '../../controller/TodoController.php';
$login_status = new TodoController();
$filename = $_SESSION['download_csv'];
$download_csv = sprintf('/app/bin/tmp/%s', $filename);
$comp_time = $_SESSION['comp_time'];

?>

<!DOCTYPE html>
 <html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Download CSV</title>
        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/css/stylesheet.css">
    </head>
<body>
<div class="wrapper-container">
    <div class="title">CSV STATUS</div>
        <div  class="board-contents"> 
            <div class="showstatus">
                <?php if(isset($filename)) : ?>
                    <div>作成完了</div>
                    <p><?php echo $comp_time; ?></p>
                    <a class="download" href=<?php echo $download_csv; ?>></a>
                <?php else : ?>
                    <p>作成中・・・</p>
                <? endif ?>
            </div>
        </div>
        <a class="link" href="./index.php">Todo Index</a>
    </div>
</div>  
</body>
</html>
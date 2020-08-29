<?php
session_start();

$download_csv = sprintf('/app/bin/tmp/%s', $_SESSION['download_csv']);

?>

<!DOCTYPE html>
 <html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Download CSV</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/css/stylesheet.css">
    </head>
<body>
<div class="wrapper-container">
    <div class="title">CSV STATUS</div>
        <div  class="board-contents"> 
        <?php if($download_csv) : ?>
            <a>作成完了</a>
            <a href=<?php echo $download_csv; ?>>todo_list.csv</a>
        <?php else : ?>
            <a>作成中・・・</a>
        <? endif ?>
        </div>
</div>  
</body>
</html>
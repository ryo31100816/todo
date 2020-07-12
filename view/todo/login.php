<?php

require_once '../../app/controller/Usercontroller.php';


// $action = new Usercontroller();
// $user = $action->register($_POST);
session_start();










?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン完了</title>
</head>
<body>
<h2>ログイン完了</h2>
<?php if(count($error) > 0) : ?>
    <?php foreach($error as $e) : ?>
    <p><?php echo $e ?></p>
    <? endforeach ?>
<?php else : ?>
    <p>ログインしました。</p>
<?php endif ?>
    <a href="mypage.php">マイページへ戻る</a>

</body>
</html>
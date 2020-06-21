<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>ユーザーフォーム</h2>
    <form action="register.php" method="POST">
    <p>
    <lablel for="username">ユーザー名:</lable>
    <input type="text" name="username">
    </p>
    <p>
    <lablel for="email">E-mail</lable>
    <input type="email" name="email">
    </p>
    <p>
    <lablel for="password">パスワード</lable>
    <input type="password" name="password">
    </p>
    <p>
    <p>
    <lablel for="password">パスワード確認</lable>
    <input type="password" name="password_conf">
    </p>
    <p>
    <input type="submit" value="sinup">
    </p>
    </form>
</body>
</html>
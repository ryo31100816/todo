
<?php
require_once '../../controller/TodoController.php';

if(isset($_POST['userid'])) {
    echo TodoController::outputCSV();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="output_csv.php" method="POST">
    <input type="hidden" name="userid" value="1">
    <input type="hidden" name="csv-action" value="csv-action">
    <button id="request" class="btn" type="submit">CSV</button>
    </form>

    <form action="test.php" method="POST">
    <input type="hidden" name="userid" value="1">
    <input type="hidden" name="csv-action" value="csv-action">
    <button id="request" class="btn" type="submit">CSV</button>
    </form>
</body>
</html>
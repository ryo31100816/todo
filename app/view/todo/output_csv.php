<?php
require_once '../../controller/TodoController.php';

if(isset($_POST['csv-action'])){

    echo TodoController::outputCSV();
    
}
<?php

if(isset($_POST['csv-action'])){
    $user_id = $_POST['userid']; 
    $cmd = "php /var/www/html/app/bin/output_csv.php ${user_id} > /dev/null &";
    exec($cmd);
}
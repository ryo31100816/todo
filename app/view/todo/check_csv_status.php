<?php

if ($_SERVER ['REQUEST_METHOD'] === 'POST'){
    $output_path = '/var/www/html/app/bin/tmp/';
    $filename = 'file_status.txt';
    $status_place = $output_path.$filename;

    $fp = fopen($status_place,'r');
    $status_line = fgetcsv($fp);
    $status = $status_line[0];
    $filename = substr($status_line[1],12);
    $status_line = array();

    if($status === 'status = 3'){
        session_start();
        $_SESSION['download_csv'] = $filename;
        echo '作成完了';
    };

    if($status === 'status = 4'){
        echo '作成失敗';
    };

    fclose($fp);
    exit;
}
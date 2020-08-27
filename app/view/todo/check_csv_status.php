<?php

$output_path = './tmp/';
$filename = 'file_status.txt';
$status_place = $output_path.$filename;

$fp = fopen($status_place,'r');
$status_line = fgetcsv($fp);
$status = $status_line[0];
$status_line = array();

if($status === 'status = 3'){
    // 完了したらダウンロードページへ
};

if($status === 'status = 4'){
    // 失敗字メッセ
};

fclose($fp);
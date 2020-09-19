<?php
require_once '/var/www/html/app/model/Todo.php';

$user_id = $argv[1];
$output_path = '/var/www/html/app/bin/tmp/';
$filename = sprintf('todo_list_userid=%s_%s.csv',$user_id,date('Ymd',time()));
$csv_place = $output_path.$filename;

$file_status = 'file_status.txt';
$status_place = $output_path.$file_status;
$status_fp = fopen($status_place,'w');

function updateStatus($status, $status_fp, $filename) {
    rewind($status_fp);
    $status_line = sprintf('status = %s, filename = %s, update = %s',$status,$filename,date('H:i:s',time()));
    fwrite($status_fp,$status_line);
}

updateStatus($status = 1, $status_fp, $filename);
$query = sprintf('SELECT * FROM todos WHERE user_id = %s;',$user_id);
$stmh_result = Todo::fetchFindBYQuery($query);

if($stmh_result){
    updateStatus($status = 2, $status_fp, $filename);

    $fp = fopen($csv_place,'w');
    if($fp){
        $line = $stmh_result->fetch(PDO::FETCH_ASSOC);
        $header_line = array_keys($line);
        fputcsv($fp,$header_line);
        $line = mb_convert_encoding($line,'SJIS','UTF8');
        fputcsv($fp,$line);
        $count++;
        while($line = $stmh_result->fetch(PDO::FETCH_ASSOC)){
                $line = mb_convert_encoding($line,'SJIS','UTF8');
                fputcsv($fp,$line);
                $count++;
        }
    }
}
$result = fclose($fp);
if($result){
    updateStatus($status = 3, $status_fp, $filename);
    fclose($status_fp);
    echo true;
    return;
}else{
    updateStatus($status = 4, $status_fp, $filename);
    fclose($status_fp);
    echo false;
    return;
}
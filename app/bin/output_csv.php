<?php
require_once '../model/Todo.php';

$user_id = $argv[1];
$output_path = './tmp/';
$filename = sprintf('todo_list_userid=%s_%s.csv',$user_id,date('Ymd',time()));
$csv_place = $output_path.$filename;

$file_status = 'file_status.txt';
$status_place = $output_path.$file_status;
$status_fp = fopen($status_place,'w');

$status = sprintf('status = 1, ファイル名 = %s, 更新時間 = %s',$filename,date('H:i:s',time()));
fwrite($status_fp,$status);

$query = sprintf('SELECT * FROM todos WHERE user_id = %s;',$user_id);
$todo_lists = Todo::findBYQuery($query);

rewind($status_fp);
$status = sprintf('status = 2, ファイル名 = %s, 更新時間 = %s',$filename,date('H:i:s',time()));
fwrite($status_fp,$status);

$fp = fopen($csv_place,'w');
if($fp){
    $header_title = array_keys($todo_lists[0]);
    fputcsv($fp,$header_title);
    foreach($todo_lists as $todo_list){
        $todo_lists = mb_convert_encoding($line,'SJIS','UTF8');
        fputcsv($fp,$todo_list);
        $count++;
    }
}
$result = fclose($fp);
if($result){
    rewind($status_fp);
    $status = sprintf('status = 3, ファイル名 = %s,件数 = %s, 更新時間 = %s',$filename,$count,date('H:i:s',time()));
    fwrite($status_fp,$status);
    fclose($status_fp);
}else{
    rewind($status_fp);
    $status = sprintf('status = ERROR, ファイル名 = %s, 更新時間 = %s',$filename,date('H:i:s',time()));
    fwrite($status_fp,$status);
    fclose($status_fp);
}
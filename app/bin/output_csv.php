<?php
require_once '../model/Todo.php';

$cmd = 'php /bin/output_csv.php > /dev/null &';
exec($cmd);

$user_id = $_POST['userid'];
// $user_id = $argv[1];
$output_path = './tmp/';
$filename = sprintf('todo_list_userid=%s_%s.csv',$user_id,date('Ymd',time()));
$csv_place = $output_path.$filename;

$file_status = 'file_status.txt';
$status_place = $output_path.$file_status;
$status_fp = fopen($status_place,'w');

function updateStatus($status, $status_fp, $filename) {
    rewind($status_fp);
    $status_line = sprintf('status = %s, ファイル名 = %s, 更新時間 = %s',$status,$filename,date('H:i:s',time()));
    fwrite($status_fp,$status_line);
}

updateStatus($status = 1, $status_fp, $filename);

$query = sprintf('SELECT * FROM todos WHERE user_id = %s;',$user_id);
$todo_lists = Todo::findBYQuery($query);

updateStatus($status = 2 ,$status_fp, $filename);

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
    updateStatus($status = 3, $status_fp, $filename);
    fclose($status_fp);
    return true;
}else{
    updateStatus($status = 4, $status_fp, $filename);
    fclose($status_fp);
    return false;
}
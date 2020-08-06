<?php
require_once '../../app/controller/Todocontroller.php';

$dbh = new PDO(DSN,USER,PASSWORD);
$stmh = $dbh->query('SELECT * FROM todos');
$todo_list = $stmh->fetchAll(PDO::FETCH_ASSOC);

$write_data[] = array_keys($todo_list[0]);
foreach($todo_list as $todo_data){
    $write_data[] = mb_convert_encoding($todo_data,'SJIS','UTF8');
}

$file_path = 'todolist.csv';
$fp = new SplFileObject($file_path, 'w');
foreach($write_data as $line){
    $fp->fputcsv($line);
}

header('Content-Type: application/octet-stream');
header('Content-Length: '.filesize($fp));
header('Content-Disposition: attachment; filename='.$file_path);
readfile($file_path);
exit();
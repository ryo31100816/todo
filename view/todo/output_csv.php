<?php
require_once '../../app/model/Todo.php';

$todo = new Todo();
$dbh = $todo->dbConnect();
$user_id = $_POST['userid'];
$query = sprintf('SELECT * FROM todos WHERE user_id = %s;',$user_id);
$stmh = $dbh->query($query);
$todo_list = $stmh->fetchAll(PDO::FETCH_ASSOC);

// $write_data[] = array_keys($todo_list[0]);
// foreach($todo_list as $todo_data){
//     $write_data[] = mb_convert_encoding($todo_data,'SJIS','UTF8');
// }

header("Content-Type: application/json; charset=UTF-8");
echo json_encode($todo_list);
exit;

// $file_path = 'todolist.csv';
// $fp = new SplFileObject($file_path, 'w');
// foreach($write_data as $line){
//     $fp->fputcsv($line);
// }

// header('Content-Type: application/octet-stream');
// header('Content-Length: '.filesize($fp));
// header('Content-Disposition: attachment; filename='.$file_path);
// $fp = null;
// $result = readfile($file_path);
// if($result > 0){
//     echo '出力しました。';
//     return;
// }
// echo '失敗しました。';
// return;
<?php

require_once('../../app/model/Todo.php');
require_once('../../app/validation/Todovalidation.php');

class Todocontroller{
    public function index(){
       $todo_list = Todo::findAll();
       
       return $todo_list;
    }

    public function detail(){
        $todo_id = $_GET['todo_id'];

        $todo = Todo::findById($todo_id);

        return $todo;
    }

    public function new(){
        $data = array(
            "title" => $_POST['title'],
            "detail" => $_POST['detail'],
        );

        $validation = new Todovalidation;
        $validation->setData($data);
        if($validation->check() === false) {
  
            $error_msgs = $validation->getErrorMessages();

            session_start();
            $_SESSION['error_msgs'] = $error_msgs;
                // var_dump($_SESSION['error_msgs'] );
                // exit;
            $params = sprintf('?title=%s&detail=%s', $title, $detail);
            header("Location: ../../view/todo/new.php" . $params);
            return;
        }
    

        $validate_data = $validation->getData($data);
        $title = $validate_data['title'];
        $detail = $validate_data['detail'];

        $todo = new Todo();
        $todo->setTitle($title);
        $todo->setDetail($detail);
        $result = $todo->save();

        if($result === false) {
            $params = sprintf("?title=%s&detail=%s", $title, $detail);
            header( "Location: ../../view/todo/new.php" . $params);
        }
            header( "Location: ../../view/todo/index.php" );
    }

    public function edit(){
        $todo_id = $_GET['todo_id'];
        $todo = Todo::findById($todo_id);
        if($_SERVER["REQUEST_METHOD"] !== "POST"){
            return $todo;
        }
  
        $data = array(
            "title" => $_POST['title'],
            "detail" => $_POST['detail'],
        );

        $validation = new Todovalidation;
        $validation->setData($data);
        if($validation->check() === false) {
            $error_msgs = $validation->getErrorMessages();
         
            //セッションにエラーメッセージを追加
            session_start();
            $_SESSION['error_msgs'] = $error_msgs;
    
            $params = sprintf("?title=%s&detail=%s",
                        $title,$detail);
            header("Location: ../../view/todo/edit.php" . $params);
            return;
        }
         
        $validate_data = $validation->getData($data);
        $title = $validate_data['title'];
        $detail = $validate_data['detail'];
           
        $todo = new Todo();
        $todo->todo_id = $_POST['todo_id'];
        $todo->setTitle($title);
        $todo->setDetail($detail);
        $param = $_SERVER['QUERY_STRING'];
        // var_dump($todo);
        // exit;

        $todo->update();
        //updateが実行しても更新されない。トランザクションもコミットされている。。。要確。todo_idを取得してupdateに返さないと更新できないはず
        header( "Location: ../../view/todo/index.php" );   
    }

    public function delete(){
        $todo_id = $_GET['todo_id'];
        $is_exist = Todo::isExistById($todo_id);
        if(!$is_exist) {
                session_start();
                $_SESSION['error_msgs'] = [
                        sprintf("id=%sに該当するレコードが存在しません",
                        $todo_id)
                        ];
        header("Location: ../../view/todo/index.php");
        return;
        }

        $todo = new Todo;
        $todo->setId($todo_id);
        $result = $todo->delete();
        if($result === false) {
                session_start();
                $_SESSION['error_msgs'] = [
                                        sprintf("削除に失敗しました。id=%s", 
                                        $todo_id)
                                        ];
        }
        header("Location: ../../view/todo/index.php");
    }
}

?>
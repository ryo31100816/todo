<?php
require_once '../../app/model/Todo.php';
require_once '../../app/validation/Todovalidation.php';

class Todocontroller{

    public function __construct(){
        if(isset($_SESSION['login_user']) && $_SESSION['login_user'] > 0){
            return;
        }
        header("Location: ../../view/login/login_form.php");
        return;
    }

    public function index(){
        $user_id = $_SESSION['login_user']['user_id'];
        return Todo::findAll($user_id);
    }

    public function detail(){
        $todo_id = $_GET['todo_id'];
        $todo = Todo::findById($todo_id);
        return $todo;
    }

    public function new(){
        $data = array(
            "user_id" => $_POST['user_id'],
            "title" => $_POST['title'],
            "detail" => $_POST['detail']
        );
        $validation = new Todovalidation;
        $validation->setData($data);
        if($validation->check() === false) {
  
            $error_msgs = $validation->getErrorMessages();

            session_start();
            $_SESSION['error_msgs'] = $error_msgs;
            $params = sprintf('?title=%s&detail=%s', $title, $detail);
            header("Location: ../../view/todo/new.php" . $params);
            return;
        }
    
        $validate_data = $validation->getData($data);
        $title = $validate_data['title'];
        $detail = $validate_data['detail'];

        $todo = new Todo();
        $todo->setUserId($data['user_id']);
        $todo->setTitle($title);
        $todo->setDetail($detail);
        $result = $todo->save();

        if($result === false) {
            $params = sprintf("?title=%s&detail=%s", $title, $detail);
            header( "Location: ../../view/todo/new.php" . $params);
        }
        $_SESSION['success_msg'] = '登録しました。';
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
    
            $params = sprintf("?title=%s&detail=%s",$title,$detail);
            header("Location: ../../view/todo/edit.php" . $params);
            return;
        }
         
        $validate_data = $validation->getData($data);
        $title = $validate_data['title'];
        $detail = $validate_data['detail'];
           
        $todo = new Todo();
        $todo->setTodoId($_POST['todo_id']);
        $todo->setTitle($title);
        $todo->setDetail($detail);
        $param = $_SERVER['QUERY_STRING'];
    
        $todo->update();
        $_SESSION['success_msg'] = '編集しました。';
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
        $todo->setTodoId($todo_id);
        $result = $todo->delete();
        session_start();
        if($result === false) {
            $_SESSION['error_msgs'] = [
                sprintf("削除に失敗しました。id=%s", 
                $todo_id)
            ];
        }
        $_SESSION['success_msg'] = '削除しました。';
        header("Location: ../../view/todo/index.php");
    }
}
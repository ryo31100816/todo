<?php
require_once '../../model/Todo.php';
require_once '../../validation/TodoValidation.php';

class TodoController{

    public function __construct(){
        if(isset($_SESSION['login_user']) && $_SESSION['login_user'] > 0){
            return;
        }
        header("Location: ../../view/login/login_form.php");
        return;
    }

    public function index(){
        $user_id = $_SESSION['login_user']['user_id'];
        if(isset($_GET['search'])){
            $search_word = '%'.$_GET['word'].'%';
            $search_word = $this->search($search_word);
            $search_comp = $_GET['completed_at'];
            $query = $this->getQuery($user_id,$search_word,$search_comp);
            return Todo::findByQuery($query);
        }
        return Todo::findAll($user_id);
    }

    public function getQuery($user_id,$search_word,$search_comp){
        $query = sprintf("SELECT * FROM todos WHERE user_id = %s AND title LIKE '%s' AND completed_at  IS %s;",
            $user_id, $search_word,$search_comp);
        return $query;
    }

    public function search($search_word){
        $search_word = htmlspecialchars($search_word,ENT_QUOTES,'utf-8');
        $validation = new TodoValidation;
        $validation->setData($search_word);
        if($validation->checkSearch() === false) {
            header("Location: ../../view/todo/index.php");
            return;
        }
        $validate_data = $validation->getData();
        return $validate_data;
    }

    public function detail(){
        $todo_id = $_GET['todo_id'];
        $todo = Todo::findById($todo_id);
        if($todo){
            return $todo;
        }
        header('Location: ../../view/errors/404.php');
        return;
    }

    public function new(){
        $data = array(
            "user_id" => $_POST['user_id'],
            "title" => $_POST['title'],
            "detail" => $_POST['detail']
        );
        $validation = new TodoValidation;
        $validation->setData($data);
        if($validation->check() === false) {
  
            $error_msgs = $validation->getErrorMessages();

            session_start();
            $_SESSION['error_msgs'] = $error_msgs;
            $params = sprintf('?title=%s&detail=%s', $title, $detail);
            header("Location: ../../view/todo/new.php" . $params);
            return;
        }
    
        $validate_data = $validation->getData();
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

        $validation = new TodoValidation;
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
         
        $validate_data = $validation->getData();
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
            return;
        }
        $_SESSION['success_msg'] = '削除しました。';
        header("Location: ../../view/todo/index.php");
    }

    public function complete(){
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
        $result = $todo->complete();
        session_start();
        if($result === false) {
            $_SESSION['error_msgs'] = [
                sprintf("登録に失敗しました。id=%s", 
                $todo_id)
            ];
            return;
        }
        $_SESSION['success_msg'] = '完了状態にしました。';
        header("Location: ../../view/todo/index.php");
    }

    public static function outputCSV(){
        $todo = new Todo();
        $dbh = $todo->dbConnect();
        $user_id = $_POST['userid'];
        $query = sprintf('SELECT * FROM todos WHERE user_id = %s;',$user_id);
        $stmh = $dbh->query($query);
        $todo_list = $stmh->fetchAll(PDO::FETCH_ASSOC);

        header("Content-Type: application/json; charset=UTF-8");
        return json_encode($todo_list);
    }

}
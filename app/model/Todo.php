<?php
require_once('../../app/config/database.php');

class Todo{
    private $todo_id;
    private $user_id;
    private $title;
    private $detail;
    private $status;

    public function getTitle() {
        return $this->title;
    }
         
    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function getDetail() {
        return $this->detail;
    }

    public function setDetail($detail) {
        $this->detail = $detail;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }        

    public function setTodoId($todo_id) {
        $this->todo_id = $todo_id;
    }
    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public static function findByQuery($query){
        $dbh = new PDO(DSN, USER, PASSWORD);
        $stmh = $dbh->query($query);

        if($stmh){
            $todo_list = $stmh->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $todo_list = [];
        }
        return $todo_list;
    }

    public static function findAll($user_id) {
        $dbh = new PDO(DSN, USER, PASSWORD);
        $stmh = $dbh->query(sprintf('SELECT * FROM todos WHERE user_id = %s',$user_id));

        if($stmh){
            $todo_list = $stmh->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $todo_list = [];
        }
        return $todo_list;
    }

    public static function findById($todo_id){
        $dbh = new PDO(DSN, USER, PASSWORD);
        $stmh = $dbh->query(sprintf('SELECT * FROM todos WHERE id = %s', $todo_id));

        if($stmh){
            $todo = $stmh->fetch(PDO::FETCH_ASSOC);
        }else{
            $todo = [];
        }
        return $todo;
    }

    public function save(){
        $query = sprintf("INSERT INTO `todos` (`title`, `detail`, `status`,`user_id`,`created_at`, `updated_at`)
                    VALUES ('%s', '%s', 0, %s,NOW(), NOW());",$this->title, $this->detail,$this->user_id);
        $dbh = new PDO(DSN, USER, PASSWORD);
    
        try {
            // トランザクション開始
            $dbh->beginTransaction();

            $stmt = $dbh->prepare($query);
            $stmt->execute();

            // コミット
            $dbh->commit();

        } catch(PDOException $e) {

            // ロールバック
            $dbh->rollBack();

            // エラーメッセージ出力
            echo $e->getMessage();
        }
        return $result;
    }

    public function update(){
        $query = sprintf("UPDATE `todos` SET title = '%s', detail = '%s' WHERE id = '%s';", 
                    $this->title, 
                    $this->detail,
                    $this->todo_id
                    );
                
        $dbh = new PDO(DSN, USER, PASSWORD);
        try {
            // トランザクション開始
            $dbh->beginTransaction();
                
            $stmt = $dbh->prepare($query);
    
            $stmt->execute();
            
            // コミット
            $dbh->commit();
            
        } catch(PDOException $e) {
            
            // ロールバック
            $dbh->rollBack();
        
            // エラーメッセージ出力
            echo $e->getMessage();
        }
    }

    public static function isExistById($todo_id) {
        $dbh = new PDO(DSN, USER, PASSWORD);
        $query = sprintf('SELECT * FROM `todos` WHERE id = %s', $todo_id);
        $stmh = $dbh->query($query);
        if(!$stmh) {
            return false;
        }
        return true;
    }

    public function delete() {
        try {
            $dbh = new PDO(DSN, USER, PASSWORD);
        
            // トランザクション開始
            $dbh->beginTransaction();
            $query = sprintf("DELETE FROM todos WHERE id = %s", $this->id);

            $stmt = $dbh->prepare($query);
            $result = $stmt->execute();

            $dbh->commit();
        } catch (PDOException $e) {
            // ロールバック
            $dbh->rollBack();

            echo $e->getMessage();
            $result = false;
        }
        return $result;
    }
}
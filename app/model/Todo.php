<?php
require_once '../../app/model/Bassmodel.php';

class Todo extends Bassmodel{
    private $todo_id;
    private $user_id;
    private $title;
    private $detail;
    private $status;
    private $search_word;
    private $search_comp;

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

    public function setSearch($search_word,$search_comp) {
        $this->search_word = $search_word;
        $this->search_comp = $search_comp;
    }

    public static function findByQuery($query){
        $pdo = self::dbConnect();
        $dbh = $pdo;
        $stmh = $dbh->query($query);

        if($stmh){
            $todo_list = $stmh->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $todo_list = [];
        }
        return $todo_list;
    }

    public static function findAll($user_id) {
        $pdo = self::dbConnect();
        $dbh = $pdo;
        $stmh = $dbh->query(sprintf('SELECT * FROM todos WHERE user_id = %s',$user_id));

        if($stmh){
            $todo_list = $stmh->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $todo_list = [];
        }
        return $todo_list;
    }

    public static function findById($todo_id){
        $pdo = self::dbConnect();
        $dbh = $pdo;
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
        $dbh = $this->dbConnect();
    
        try {
            $dbh->beginTransaction();
            $stmt = $dbh->prepare($query);
            $stmt->execute();
            $dbh->commit();
        } catch(PDOException $e) {
            $dbh->rollBack();
            echo $e->getMessage();
        }
        return $result;
    }

    public function update(){
        $query = sprintf("UPDATE `todos` SET title = '%s', detail = '%s' WHERE id = '%s';", 
                    $this->title, $this->detail,$this->todo_id);
        $dbh = $this->dbConnect();
        try {
            $dbh->beginTransaction();
            $stmh = $dbh->prepare($query);
            $stmh->execute();
            $dbh->commit();
        } catch(PDOException $e) {
            $dbh->rollBack();
            echo $e->getMessage();
        }
    }

    public static function isExistById($todo_id) {
        $query = sprintf('SELECT * FROM `todos` WHERE id = %s', $todo_id);
        $pdo = self::dbConnect();
        $dbh = $pdo;
        $stmh = $dbh->query($query);
        
        if(!$stmh) {
            return false;
        }
        return true;
    }

    public function delete() {
        $query = sprintf("DELETE FROM todos WHERE id = %s", $this->todo_id);
        $dbh = $this->dbConnect();
        try {
            $dbh->beginTransaction();
            $stmh = $dbh->prepare($query);
            $result = $stmh->execute();
            $dbh->commit();
        } catch (PDOException $e) {
            $dbh->rollBack();
            echo $e->getMessage();
            $result = false;
        }
        return $result;
    }

    public function search(){
        $search_word = '%'.$this->search_word.'%';
        $query = sprintf("SELECT * FROM todos WHERE user_id = %s AND title LIKE '%s' AND completed_at  IS %s;",
                 $this->user_id, $search_word,$this->search_comp);
        $dbh = $this->dbConnect();
        $stmh =$dbh->query($query);
        if($stmh){
            $todo_list = $stmh->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $todo_list = [];
        }
        return $todo_list;
    }

    public function complete(){
        $query = sprintf("UPDATE `todos` SET completed_at = NOW() WHERE id = '%s';",$this->todo_id);
        $dbh = $this->dbConnect();
        try {
            $dbh->beginTransaction();
            $stmh = $dbh->prepare($query);
            $stmh->execute();
            $dbh->commit();
        } catch(PDOException $e) {
            $dbh->rollBack();
            echo $e->getMessage();
        }
    }
}
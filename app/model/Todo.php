<?php
require_once('../../app/config/database.php');

class Todo{
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

    public function setId($todo_id) {
        $this->id = $todo_id;
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

    public static function findAll() {
        $dbh = new PDO(DSN, USER, PASSWORD);
        $stmh = $dbh->query('SELECT * FROM todos');

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
        $query = sprintf("INSERT INTO `todos` (`title`, `detail`, `status`,`created_at`, `updated_at`)
                    VALUES ('%s', '%s', 0, NOW(), NOW());",$this->title, $this->detail);
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
            // var_dump($query);
            // exit;
                
            $dbh = new PDO(DSN, USER, PASSWORD);
            // $stmt = $dbh->prepare($query);
            // $result = $stmt->execute();
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
?>
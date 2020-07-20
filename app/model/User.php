<?php
require_once '../../app/config/database.php';

class User{
    public $pdo;

    private $username;
    private $email;
    private $password;
    private $status;

    public function __construct(){
        $this->dbConnect();
    }
    public function dbConnect(){
        $this->pdo = new PDO(DSN, USER, PASSWORD);
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getEmail() {
        return $this->title;
    }
         
    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function getpassword() {
        return $this->detail;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
    
    public function new_User(){
        $query = sprintf("INSERT INTO `users` (`username`,`email`,`password`)VALUES ('%s','%s','%s');",
            $this->username,$this->email,$this->password
        );
        $dbh = new PDO(DSN, USER, PASSWORD);

        try{
            $dbh->beginTransaction();
            
            $stmh = $dbh->prepare($query);
            $stmh->execute();

            $result = $dbh->commit();

        } catch(PDOException $e) {
            // ロールバック
            $dbh->rollBack();

            // エラーメッセージ出力
            echo $e->getMessage();
        }
        return $result;
    }

    public static function getUserByEmail($email){
        $pdo = new PDO(DSN, USER, PASSWORD);
        $query = sprintf("SELECT * FROM `users` WHERE email = '%s';",$email);
      
        try{
            $stmh = $pdo->prepare($query);
            $stmh->execute();
            $user = $stmh->fetch();
            return $user;
        }catch(PDOException $e){
            return $result;
        }
    }
}


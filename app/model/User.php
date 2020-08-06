<?php
// require_once '../../app/config/database.php';
require_once '../../app/model/Bassmodel.php';

class User extends Bassmodel{
    // public $pdo;

    private $username;
    private $email;
    private $password;
    private $status;

    // public function __construct(){
    //     $this->dbConnect();
    // }
    // public function dbConnect(){
    //     $this->pdo = new PDO(DSN, USER, PASSWORD);
    // }

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
        $dbh = $this->pdo;

        try{
            $dbh->beginTransaction();
            $stmh = $dbh->prepare($query);
            $stmh->execute();
            $result = $dbh->commit();
        } catch(PDOException $e) {
            $dbh->rollBack();
            echo $e->getMessage();
        }
        return $result;
    }

    public static function getUserByEmail($email){
        $query = sprintf("SELECT * FROM `users` WHERE email = '%s';",$email);
        $pdo = self::dbConnect();
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


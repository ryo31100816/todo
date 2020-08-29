<?php
require_once 'Bassmodel.php';

class User extends Bassmodel{

    const TOKEN_LIMIT = 3600;
    private $user_id;
    private $username;
    private $email;
    private $password;
    private $token;

    public function setUserId($user_id) {
        $this->user_id = $user_id;
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

    public function setToken($token) {
        $this->token = $token;
    }

    public function preRegister(){
        $query = sprintf("INSERT INTO `users` (`email`, `created_at`, `updated_at`, `token`, `token_registed_at`) VALUES ('%s', NOW(), NOW(), '%s', NOW());",
            $this->email, $this->token
        );
        $dbh = $this->dbConnect();
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
    
    public function newUser(){
        $query = sprintf("UPDATE `users` SET `username` = '%s', `password` = '%s' WHERE `user_id` = '%s';",
            $this->username,$this->password,$this->user_id
        );
        $dbh = $this->dbConnect();
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
        $query = sprintf("SELECT * FROM `users` WHERE `email` = '%s';", $email);
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

    public static function getUserByToken($token){
        $query = sprintf("SELECT * FROM `users` WHERE `token` = '%s';", $token);
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


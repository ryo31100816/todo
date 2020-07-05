<?php

require_once('../../app/model/User.php');
require_once('../../app/validation/Uservalidation.php');

class Usercontroller{

    public static function register($userdata){
        $user = [];

        $user['username'] =$_POST['username'];
        $user['email'] =$_POST['email'];
        $user['password'] =password_hash($_POST['password'],PASSWORD_DEFAULT);

        $query = sprintf("INSERT INTO `users` (`username`,`email`,`password`)
                    VALUES ('%s','%s','%s');",$user['username'],$user['email'],$user['password']);
        $dbh = new PDO(DSN, USER, PASSWORD);

        try{
            $dbh->beginTransaction();
            
            $stmh = $dbh->prepare($query);
            $stmh->execute();

            $result = $dbh->commit();

            //bool(true)となるがデータベースにデータがない
            var_dump($result);
        } catch(PDOException $e) {
            // ロールバック
            $dbh->rollBack();

            // エラーメッセージ出力
            return $e->getMessage();
        }
    }

    public static function login($email,$password){
        $result = false;
        $user = self::getUserByEmail($email);

        // var_dump($user);
        // exit;

        if(!$user){
            $_SESSION['msg'] = 'emailが一致しません。';
            return $result;
        }

        if(password_verify($password,$user['password'])){
            session_regenerate_id(true);
            $_SESSION['login_user'] = $user;
            $result =true;
            return $result;
        }

        $_SESSION['msg'] = 'パスワードが一致しません。';
        return $result;


    }

    public static function getUserByEmail($email){

        $query = sprintf("SELECT * FROM `users` WHERE email = '%s';",$email);
        $dbh = new PDO(DSN, USER, PASSWORD);

        try{
            $stmh = $dbh->prepare($query);
            $stmh->execute();
            $user = $stmh->fetch();
            return $user;
        }catch(PDOException $e){
            return $result;
        }
    }

    public static function checkLogin(){
        $result = false;
        // var_dump($_SESSION);
        // exit;
        if(isset($_SESSION['login_user']) && $_SESSION['login_user'] > 0){
            return $result = true;
        }
        return $result;
    }

    public static function logout(){
        $_SESSION = array();
        session_destroy();
    }

}
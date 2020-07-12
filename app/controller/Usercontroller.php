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

        } catch(PDOException $e) {
            // ロールバック
            $dbh->rollBack();

            // エラーメッセージ出力
            return $e->getMessage();
        }
    }

    public static function login($email,$password){
        $data = array(
            'email' => $email,
            'password' => $password
        );
        $validation = new Uservalidation;
        $validation->setData($data);
        if($validation->check() === false) {
            $error_msgs = $validation->getErrorMessages();
            session_start();
            $_SESSION['error_msgs'] = $error_msgs;
            header("Location: ../../view/todo/login_form.php");
            return;
        }
        // if(!$email = filter_input(INPUT_POST,'email')){
        //     $error['email'] = 'メールアドレスを入力してください。';
        // }
        // if(!$password = filter_input(INPUT_POST,'password')){
        //     $error['password'] = 'パスワードを入力してください。';
        // }
        // var_dump($user);
        // exit;
        $validate_data = $validation->getData($data);
        $email = $validate_data['email'];
        $password = $validate_data['password'];

        $user = User::getUserByEmail($email);
        if(!$user){
            $_SESSION['msg'] = 'emailが一致しません。';
            return false;
        }
        if(password_verify($password,$user['password'])){
            session_regenerate_id(true);
            $_SESSION['login_user'] = $user;
            return true;
        }
        $_SESSION['msg'] = 'パスワードが一致しません。';
        return false;
    }

    public static function checkLogin(){
        // var_dump($_SESSION);
        // exit;
        if(isset($_SESSION['login_user']) && $_SESSION['login_user'] > 0){
            return true;
        }
        return false;
    }

    public static function logout(){
        $_SESSION = array();
        session_destroy();
    }
    public static function h($str){
        return htmlspecialchars($str,ENT_QUOTES,'utf-8');
    }
    
    public static function setToken(){
        $csrf_token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrf_token;
        return $csrf_token;
    }
}
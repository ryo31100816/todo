<?php
require_once (__DIR__.'/../model/User.php');
require_once (__DIR__.'/../validation/LoginValidation.php');

class LoginController{

    public function __construct(){
        if(isset($_SESSION['login_user']) && $_SESSION['login_user'] > 0){
            header("Location: ../login/mypage.php");
            return;
        }
        return;
    }

    public function login(){
        $data = array(
            'email' => $_POST['email'],
            'password' => $_POST['password']
        );
        $validation = new LoginValidation;
        $validation->setData($data);
        if($validation->check() === false) {
            $error_msgs = $validation->getErrorMessages();
            $_SESSION['error_msgs'] = $error_msgs;
            header("Location: ../../view/login/login_form.php");
            exit();
        }
        $validate_data = $validation->getData();
        $email = $validate_data['email'];
        $password = $validate_data['password'];

        $user = User::getUserByEmail($email);
        if(password_verify($password,$user['password'])){
            session_regenerate_id(true);
            $_SESSION['login_user'] = $user;
            return true;
        }
        if(!$user){
            $_SESSION['error_msgs']['email'] = 'emailが一致しません。';
            return false;
        }
        $_SESSION['error_msgs']['password'] = 'パスワードが一致しません。';
        return false;
    }

    public static function logout(){
        $_SESSION = array();
        session_destroy();
    }

    public function checkLogin(){
        if(isset($_SESSION['login_user']) && $_SESSION['login_user'] > 0){
            return true;
        }
        return false;
    }

    public static function escape($str){
        return htmlspecialchars($str,ENT_QUOTES|ENT_HTML5,'utf-8');
    }
    
    public static function setToken(){
        $csrf_token = bin2hex(random_bytes(32));
        session_start();
        $_SESSION['csrf_token'] = $csrf_token;
        return $csrf_token;
    }

}
<?php
require_once '../../model/User.php';
require_once '../../validation/LoginValidation.php';

class LoginController{

    public static function login(){
        $data = array(
            'email' => $_POST['email'],
            'password' => $_POST['password']
        );
        $validation = new LoginValidation;
        $validation->setData($data);
        if($validation->check() === false) {
            $error_msgs = $validation->getErrorMessages();
            session_start();
            $_SESSION['error_msgs'] = $error_msgs;
            header("Location: ../../view/login/login_form.php");
            return;
        }
        $validate_data = $validation->getData();
        $email = $validate_data['email'];
        $password = $validate_data['password'];

        $user = User::getUserByEmail($email);
        if(!$user){
            $_SESSION['error_msgs'] = 'emailが一致しません。';
            return false;
        }
        if(password_verify($password,$user['password'])){
            session_regenerate_id(true);
            $_SESSION['login_user'] = $user;
            return true;
        }
        $_SESSION['error_msgs'] = 'パスワードが一致しません。';
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
        return htmlspecialchars($str,ENT_QUOTES,'utf-8');
    }
    
    public static function setToken(){
        $csrf_token = bin2hex(random_bytes(32));
        session_start();
        $_SESSION['csrf_token'] = $csrf_token;
        return $csrf_token;
    }

}
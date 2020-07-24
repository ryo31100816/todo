<?php
require_once '../../app/model/User.php';
require_once '../../app/validation/Uservalidation.php';

class Usercontroller{

    public function register(){
        $data = array(
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'password_conf' => $_POST['password_conf']
        );
        $validation = new Uservalidation;
        $validation->setData($data);
        if($validation->register_check() === false) {
            $error_msgs = $validation->getErrorMessages();
            session_start();
            $_SESSION['error_msgs'] = $error_msgs;
            header("Location: ../../view/login/signup_form.php");
            return;
        }

        $validate_data = $validation->getData($data);
        $username = $validate_data['username'];
        $email = $validate_data['email'];
        $password = password_hash($validate_data['password'],PASSWORD_DEFAULT);

        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);
        $result = $user->new_user();

        if($result === false) {
            header("Location: ../../view/login/signup_form.php");
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
            header("Location: ../../view/login/login_form.php");
            return;
        }
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

    public function checkLogin(){
        if(isset($_SESSION['login_user']) && $_SESSION['login_user'] > 0){
            return true;
        }
        return false;
    }

    public static function logout(){
        $_SESSION = array();
        session_destroy();
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
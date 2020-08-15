<?php
require_once '../../app/model/User.php';
require_once '../../app/validation/Uservalidation.php';

class Usercontroller{

    public function register(){
        $data = array(
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'password_conf' => $_POST['password_conf']
        );
        $validation = new Uservalidation;
        $validation->setData($data);
        if($validation->registerCheck() === false) {
            $error_msgs = $validation->getErrorMessages();
            session_start();
            $_SESSION['error_msgs'] = $error_msgs;
            header("Location: ../../view/login/signup_form.php");
            return;
        }

        $validate_data = $validation->getData();
        $user_id = $_SESSION['pre_user']['user_id'];
        $username = $validate_data['username'];
        $password = password_hash($validate_data['password'],PASSWORD_DEFAULT);

        $user = new User();
        $user->setUserId($user_id);
        $user->setUsername($username);
        $user->setPassword($password);
        $result = $user->newUser();
        if($result === false) {
            header("Location: ../../view/login/signup_form.php");
        }
        return true;
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
        $validate_data = $validation->getData();
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

    public function preRegister(){
        $email = $_POST['email'];
        $validation = new Uservalidation;
        $validation->setData($email);
        if($validation->preRegisterCheck() === false) {
            $error_msgs = $validation->getErrorMessages();
            $_SESSION['error_msgs'] = $error_msgs;
            header("Location: ../../view/login/pre_signup_form.php");
            return;
        }
        $user = new User();
        $email = $validation->getData();
        $user->setEmail($email);
        $token = Usercontroller::escape(Usercontroller::setToken());
        $user->settoken($token);
        $result = $user->preRegister();
        if($result){
            $to = $email;
            $subject = 'Please Regist Your Account!';
            $param = sprintf('?token=%s', $token);
            $url = 'http://127.0.0.1:8000/view/login/signup_form.php'.$param;
            $message = 'Click this URL:'.$url;
            $from = 'admin@mail.com';
            $header = "From: ".$from."\r\n";
            mb_language('Japanese');
            mb_internal_encoding("UTF-8");
            $send_result = mb_send_mail($to,$subject,$message,$header);
        }
        if($send_result){
            return true;
        }
        return false;
    }

    public function checkpreRegist(){
        $token = $_GET['token'];
        $user = User::getUserByToken($token);
        if($token !== $user['token']){
            $_SESSION['error_msgs'] [] = 'トークンが正しくありません。';
            return;
        }
        $now_time = date('Y-m-d h:i:s');
        $registed_time = date($user['token_registed_at']);
        $diff_hour = (strtotime($now_time) - strtotime($registed_time));      
        if($diff_hour > TOKEN_LIMIT){
            $_SESSION['error_msgs'] [] = 'トークンの有効期限が切れています。再登録してください。';
            return;
        }
        $_SESSION['pre_user'] = $user;
        return true;
    }
}
<?php
require_once (__DIR__.'/../model/User.php');
require_once (__DIR__.'/../validation/UserValidation.php');
require_once (__DIR__.'/../validation/PreUserValidation.php');
require_once (__DIR__.'/../service/MailService.php');

class UserController{

    public function register(){
        $data = array(
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'password_conf' => $_POST['password_conf']
        );
        $validation = new UserValidation;
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
        $validation = new PreUserValidation;
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
        $token = UserController::escape(UserController::setToken());
        $user->settoken($token);
        $result = $user->preRegister();
        if($result){
            $send_result = MailService::sendMail($email,$token);
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
        if($diff_hour > User::TOKEN_LIMIT){
            $_SESSION['error_msgs'] [] = 'トークンの有効期限が切れています。再登録してください。';
            return;
        }
        $_SESSION['pre_user'] = $user;
        return true;
    }

}
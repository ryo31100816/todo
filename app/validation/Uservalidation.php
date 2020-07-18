<?php

class Uservalidation{
    private $data;
    private $error_msg = array();

    public function setData($data){
        $this->data = $data;
    }

    public function getData($data){
        return $this->data;
    }

    public function getErrorMessages(){
        return $this->error_msg;  
    }
    public function register_check(){
        $username = $this->data['username'];
        $email = $this->data['email'];
        $password = $this->data['password'];
        $password_conf = $this->data['password_conf'];

        if(!$username){
            $this->error_msg[] = 'ユーザー名を入力してください。';
        }

        if(!$email){
            $this->error_msg[] = 'メールアドレスを入力してください。';
        }

        if(!preg_match("/\A[a-z\d]{8,20}+\z/i",$password)){
            $this->error_msg[] = 'パスワードは英数字8文字以上20文字以下にしてください。';
        }

        if($password !== $password_conf){
            $this->error_msg[] = '確認用パスワードと異なります。';
        }
        
        if(count($this->error_msg) > 0){
            return false;
        }
        return true;
    }

    public function check(){
        $email = $this->data['email'];
        $password = $this->data['password'];

        if(empty($email)){
            $this->error_msg['email'] = 'メールアドレスを入力してください。';
        }

        if(empty($password)){
            $this->error_msg['password'] = 'パスワードを入力してください。';
        }

        if(count($this->error_msg) > 0){
            return false;
        }
        return true;
    }
}
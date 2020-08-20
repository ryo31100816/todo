<?php

class LoginValidation{

    private $data;
    private $error_msg = array();

    public function setData($data){
        $this->data = $data;
    }

    public function getData(){
        return $this->data;
    }

    public function getErrorMessages(){
        return $this->error_msg;  
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
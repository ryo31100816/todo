<?php

class PreUserValidation{
    
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

    public function preRegisterCheck(){
        $email = $this->data;
   
        if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$email)){
            $this->error_msg[] = 'メールアドレスを正しく入力してください。';
        }
        
        if(count($this->error_msg) > 0){
            return false;
        }
        return true;
    }

}
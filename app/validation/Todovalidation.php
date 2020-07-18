<?php

class Todovalidation{
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

    public function check(){
        $title = $this->data['title'];
        $detail = $this->data['detail'];

        if(empty($title)){
            $this->error_msg[] = 'タイトルが空です。';
        }

        if(empty($detail)){
            $this->error_msg[] = '詳細が空です。';
        }

        if(count($this->error_msg) > 0){
            return false;
        }
        return true;
    }
}
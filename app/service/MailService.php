<?php

class MailService{

    public static function sendMail($email,$token){
        $to = $email;
        $subject = 'Please Regist Your Account!';
        $param = sprintf('?token=%s', $token);
        $url = 'http://127.0.0.1:8000/app/view/login/signup_form.php'.$param;
        $message = 'Click this URL:'.$url;
        $from = 'admin@mail.com';
        $header = "From: ".$from."\r\n";
        mb_language('Japanese');
        mb_internal_encoding("UTF-8");
        $send_result = mb_send_mail($to,$subject,$message,$header);
        return $send_result;
    }

}
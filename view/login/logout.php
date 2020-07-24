<?php
session_start();
require_once '../../app/controller/Usercontroller.php';

if(!$logout = filter_input(INPUT_POST,'logout')){
    exit('不正なリクエストです');
}

$result = Usercontroller::checkLogin();
if(!$result){
    exit('セッションが切れたのでログインし直してください');
}

Usercontroller::logout();
header('Location: login_form.php');
return;

?>
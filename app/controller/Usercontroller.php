<?php

require_once('../../app/model/User.php');
require_once('../../app/validation/Uservalidation.php');

class Usercontroller{

    public static function register($userdata){
        $user = [];

        $user['username'] =$_POST['username'];
        $user['email'] =$_POST['email'];
        $user['password'] =password_hash($_POST['password'],PASSWORD_DEFAULT);

        $query = sprintf("INSERT INTO `users` (`username`,`email`,`password`)
                    VALUES ('%s','%s','%s');",$user['username'],$user['email'],$user['password']);
        $dbh = new PDO(DSN, USER, PASSWORD);

        try{
            $dbh->beginTransaction();
            
            $stmh = $dbh->prepare($query);
            $stmh->execute();

            $result = $dbh->commit();

            //bool(true)となるがデータベースにデータがない
            var_dump($result);
        } catch(PDOException $e) {
            // ロールバック
            $dbh->rollBack();

            // エラーメッセージ出力
            return $e->getMessage();
        }
    }
}
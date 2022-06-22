<?php
if(!defined('RESTRICTED')){
    header("Location: http://localhost/secure_web_app/login.php");
    exit;
}
session_start();

if(!(isset($_SESSION["loggedIn"]) && isset($_SESSION["userId"]) && $_SESSION["loggedIn"] == "true")) {
    session_unset();
    header("Location: http://localhost/secure_web_app/login.php");
    exit;
}else{
    $db_helper = new DB_Helper();
    $user = $db_helper->getUserDetails($_SESSION["userId"]);
    if($user){
        if($user->user_status==0) {
            session_unset();
    header("Location: http://localhost/secure_web_app/login.php");
    exit;
        } 
    }else{
        session_unset();
        header("Location: http://localhost/secure_web_app/login.php");
        exit;
    }
    
}
?>
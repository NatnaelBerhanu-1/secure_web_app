<?php

require "db_helper.php";
$username_err = $password_err = $login_error= "";
$username = $password = "";
$request_method = strtoupper($_SERVER['REQUEST_METHOD']);

if($request_method == 'GET') {
    $_SESSION['token'] = bin2hex(random_bytes(35));
}else if($request_method=='POST') {
    $token = $_POST['token'];
    if(!$token || $token !== $_SESSION['token']){
        $login_error = 'Invalid form submission';
    }
    // validate recaptcha
    $recaptcha_url="https://www.google.com/recaptcha/api/siteverify";
    $secret_key="6Lc7n4wgAAAAAGS0KV0c--2akzRUHEMVjY_zNtEc";
    $recaptcha_response=$_POST['recaptcha_response'];
    $get_recaptcha_response=file_get_contents($recaptcha_url . '?secret='.$secret_key.'&response='.$recaptcha_response);
    $response_json=json_decode($get_recaptcha_response);
    // print_r($get_recaptcha_response->score);
    if(!($response_json->success == true && $response_json->score>=0.5 && $response_json->action=='submit')){
        $login_error = 'Invalid form submission';
    }
    $username = $_POST['username'];
    $password = $_POST['password'];
    if(empty($username)) {
        $username_err = "Username field is required";
    }

    if(empty($password)) {
        $password_err = "Password field is required";
    }

    if(empty($username_err) && empty($password_err)){
        // try to sign in
        $db_helper = new DB_Helper();
        $user = $db_helper->signIn($username, $password);

        if($user) {
            // echo($user->password);
            $password_matches = password_verify($password, $user->password);
            if(!$password_matches){
                $password_err = "Password incorrect";
            }else{
                session_start();
                $_SESSION['loggedIn'] = "true";
                $_SESSION['userId'] = $user->id;
                header("Location: http://localhost/secure_web_app/dashboard.php");
                exit;
            }
        }else{
            $login_error = "User not found";
            // echo("User not found");
        }
        /***
        if(!$status) {
            $signup_error = "Something went wrong registering user, try again";
        }else{
            session_start();
            $_SESSION['loggedIn'] = "true";
            header("Location: http://localhost/secure_web_app/dashboard.php");
        }
        */
    }else{
    $_SESSION['token'] = bin2hex(random_bytes(35));
    }
}



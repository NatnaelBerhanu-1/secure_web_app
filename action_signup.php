<?php

require "db_helper.php";

$username_err = $password_err = $c_password_err = $signup_error= "";
$username = $password = $c_password = "";
$request_method = strtoupper($_SERVER['REQUEST_METHOD']);


if($request_method == 'GET') {
    $_SESSION['token'] = bin2hex(random_bytes(35));
}else
if($request_method=='POST') {
    $token = $_POST['token'];
    if(!$token || $token !== $_SESSION['token']){
        $signup_error = 'Invalid form submission';
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
    $c_password = $_POST['c_password'];
    if(empty($username)) {
        $username_err = "Username field is required";
    }

    if(empty($password)) {
        $password_err = "Password field is required";
    }else{
        // do validation for username
        // echo($password);
        if(validatePassword($password)) {
            // echo("Strong password");
        }else{
            $password_err = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
        }
    }

    if(empty($c_password)) {
        $c_password_err = "Confirmation password field is required";
    }else{
        // do validation for username
        if($password != $c_password) {
            $c_password_err = 'Confirmation password different from password';
        }
    }

    if(empty($username_err) && empty($password_err) && empty($c_password_err)){
        // Add user to database and redirect to dashboard
        $db_helper = new DB_Helper();
        $status = $db_helper->registerUser($username, $password);
        if(!$status) {
            $signup_error = "Username taken, try anotherone";
        }else{
            header("Location: http://localhost/secure_web_app/login.php");
            exit;
        }
    }else{
        $_SESSION['token'] = bin2hex(random_bytes(35));
        }
}

function validatePassword($password) {
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        return false;
    }else{
        return true;
    }
}


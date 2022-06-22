<?php


// require "db_helper.php";

$name_err = $email_err = $attachment_err = $feedback_err=$add_feedback_error= "";
$name = $email = $feedback = $attachment = "";
$request_method = strtoupper($_SERVER['REQUEST_METHOD']);

if($request_method == "GET") {
        $_SESSION['token'] = bin2hex(random_bytes(35));
}else if($request_method=='POST') {
    $token = $_POST['token'];
    $honeypot = $_POST['honeypot'];
    if( !empty( $honeypot ) ){
        $add_feedback_error = 'Invalid form submission';
	}
    if(!$token || $token !== $_SESSION['token']){
        $add_feedback_error = 'Invalid form submission';
    }
    $name = $_POST['name'];
    $email = $_POST['email'];
    $feedback = $_POST['feedback'];
    $attachment = $_FILES['attachment'];
    if(empty($name)) {
        $name_err = "name field is required";
    }if(empty($email)) {
        $email_err = "email field is required";
    }if(empty($feedback)) {
        $feedback_err = "feedback field is required";
    }if(empty($attachment)) {
        $attachment_err = "attachment field is required";
    }else{
        // check file content
        // print_r($_FILES);
        $file_type=$attachment['type'];
        $file_name = $attachment['name'];
        $file_size = $attachment['size'];
        $file_type=$attachment['type'];
        $tmp = explode('.',$file_name);
        // echo($file_type);
        $file_ext=strtolower(end($tmp));
        if($file_type!="application/pdf"){
            $attachment_err = "Only pdf files are allowed";
        }
        if($file_size > 2097152){
            $attachment_err='File size must be less than 2 MB';
        }
        
       
    }

    if(empty($name_err) && empty($email_err) && empty($feedback_err && empty($attachment_err))){
        // first upload file
        $target_dir = "uploads/";
        $file_url = "uploads\\".uniqid().".".$file_ext;
        if(move_uploaded_file($attachment["tmp_name"], $file_url)){
        // Add feedback to database
        $db_helper = new DB_Helper();
        $result = $db_helper->addFeedback($name, $email, $feedback, $file_url, $_SESSION['userId']);
        if($result) {
            header("Location: http://localhost/secure_web_app/dashboard.php");
            exit;
        }else{
            $attachment_err = "Unable to upload file";
        $_SESSION['token'] = bin2hex(random_bytes(35));

        }
        }else{
            $attachment_err = "Unable to upload file";
        $_SESSION['token'] = bin2hex(random_bytes(35));

        }
        
    }else{
        $_SESSION['token'] = bin2hex(random_bytes(35));
    }
}


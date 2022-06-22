<?php
session_start();
session_unset();
header("Location: http://localhost/secure_web_app/login.php");

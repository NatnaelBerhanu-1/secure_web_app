<?php
class DB_Helper {

    private $conn ;

    function __construct() {    
        try {
        $this->conn = new PDO("mysql:host=localhost;port=3306;dbname=secure_web_db", 'root', '');
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\Throwable $th) {
            echo($th->getMessage());
        }
    }

    function loginUser($username, $password) {
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    function registerUser($username, $password, $role=0) {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $user_exists = $this->userExists($username);
            if($user_exists) {
                return false;
            }
            $stmt = $this->conn->prepare("INSERT INTO users (username, password, role)
            VALUES (:username, :password, :role)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':role', $role);
            $stmt->execute();
            return true;
        } catch (\Throwable $th) {
            // echo($th->getMessage());
            return false;
        }
    }

    function userExists($username) {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM users where username=? limit 1');
            $stmt->execute([$username]);
            $user = $stmt->fetchObject();
            // echo(json_encode($user));
            return $user;
        } catch (\Throwable $th) {
            // echo($th->getMessage());
            return null;
        }
    }

    function signIn($username, $password) {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM users where username=? limit 1');
            $stmt->execute([$username]);
            $user = $stmt->fetchObject();
            // echo(json_encode($user));
            return $user;
        } catch (\Throwable $th) {
            // echo($th->getMessage());
            return null;
        }
    }

    function addFeedback($name, $email, $feedback, $file_url, $user_id) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO feedbacks (name, email, feedback, file_url, user_id)
        VALUES (:name, :email, :feedback, :file_url, :user_id)");
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':feedback', $feedback);
                    $stmt->bindParam(':file_url', $file_url);
                    $stmt->bindParam(':user_id', $user_id);
                    $stmt->execute();
            return true;
        } catch (\Throwable $th) {
            // echo($th->getMessage());
            return false;
        }
    }

    function getUserFeedbacks($user_id) {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM feedbacks where user_id=?');
            $stmt->execute([$user_id]);
            $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $feedbacks;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    function getUsers() {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM users where role=0');
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
    }

    function getUserDetails($user_id) {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM users where id=? limit 1');
            $stmt->execute([$user_id]);
            $user = $stmt->fetchObject();
            return $user;
        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
    }

    function updateUserStatus($user_id, $user_status) {
        try {
            $stmt = $this->conn->prepare('UPDATE USERS SET user_status = :user_status where id = :id');
            $stmt->bindParam(':user_status', $user_status);
            $stmt->bindParam(':id', $user_id);
            $stmt->execute();
        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
    }

}
<?php
require_once "models/User.php";

class AuthController {

    public function showRegister() {
        require "views/auth/register.php";
    }

    public function register() {
        $user = new User();

        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $fullname = $_POST["fullname"];

        $user->register($username, $email, $password, $fullname);
        header("Location: index.php?action=login");
    }

    public function showLogin() {
        require "views/auth/login.php";
    }

    public function login() {
        session_start();
        $userModel = new User();

        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = $userModel->checkLogin($email, $password);

        $user = $userModel->checkLogin($email, $password);

        if ($user === "DISABLED") {
            die("Tài khoản đã bị vô hiệu hóa");
        }

        if ($user) {
            $_SESSION["user"] = $user;
            header("Location: index.php?action=home");
        } else {
            echo "Sai tài khoản hoặc mật khẩu";
        }

    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?action=login");
    }
}

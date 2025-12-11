

<?php
session_start();
require "controllers/AuthController.php";

$action = $_GET["action"] ?? "login";
$auth = new AuthController();

switch ($action) {
    case "login":
        $auth->showLogin();
        break;
    case "loginPost":
        $auth->login();
        break;
    case "register":
        $auth->showRegister();
        break;
    case "registerPost":
        $auth->register();
        break;
    case "logout":
        $auth->logout();
        break;
    case "home":
        require "views/home/index.php";
        break;
    default:
        header("Location: index.php?action=home");
        break;
}

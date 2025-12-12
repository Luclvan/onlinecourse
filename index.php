<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require "controllers/AuthController.php";
require "controllers/CourseController.php";
$courseController = new CourseController();

function requireLogin() {
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?action=login");
        exit;
    }
}

function requireRole($roles) {
    requireLogin();
    if (!in_array($_SESSION['user']['role'], $roles)) {
        die("Bạn không có quyền truy cập trang này");
    }
}

// $action = $_GET["action"] ?? "login";
// $auth = new AuthController();

// switch ($action) {
//     case "login":
//         $auth->showLogin();
//         break;
//     case "loginPost":
//         $auth->login();
//         break;
//     case "register":
//         $auth->showRegister();
//         break;
//     case "registerPost":
//         $auth->register();
//         break;
//     case "logout":
//         $auth->logout();
//         break;
//     case "home":
//         require "views/home/index.php";
//         break;
//     case "instructor_courses":
//         requireRole([1]); // giảng viên
//         $courseController->index();
//         break;

//     case "course_create":
//         requireRole([1]);
//         $courseController->create();
//         break;

//     case "course_store":
//         requireRole([1]);
//         $courseController->store();
//         break;

//     default:
//         header("Location: index.php?action=home");
//         break;
        
// }
$action = $_GET['action'] ?? 'home';

$authController = new AuthController();
$courseController = new CourseController();

switch ($action) {

    /* ===== AUTH ===== */
    case 'login':
        $authController->showLogin();
        break;

    case 'loginPost':
        $authController->login();
        break;

    case 'register':
        $authController->showRegister();
        break;

    case 'registerPost':
        $authController->register();
        break;

    case 'logout':
        $authController->logout();
        break;

    /* ===== INSTRUCTOR ===== */
    case 'instructor_courses':
        requireRole([1, 2]); // giảng viên + admin
        $courseController->index();
        break;

    case 'course_create':
        requireRole([1, 2]);
        $courseController->create();
        break;

    case 'course_store':
        requireRole([1, 2]);
        $courseController->store();
        break;

    /* ===== DEFAULT ===== */
    default:
        require "views/home/index.php";
        break;
}

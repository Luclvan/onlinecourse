<?php
define('BASE_URL', '/onlinecourse');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require "controllers/AdminController.php";
require "controllers/AuthController.php";
require "controllers/CourseController.php";
require "controllers/EnrollmentController.php";

$enrollmentController = new EnrollmentController();
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
$admin = new AdminController();

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
        
    case "admin_users":
        requireRole([2]); // chỉ admin
        $authController->adminUsers();
        break;

    case "admin_user_update":
        requireRole([2]);
        $authController->adminUserUpdate();
        break;
    case "admin_categories":
        requireRole([2]);
        $authController->adminCategories();
        break;

    case "admin_category_store":
        requireRole([2]);
        $authController->adminCategoryStore();
        break;

    case "admin_category_delete":
        requireRole([2]);
        $authController->adminCategoryDelete();
        break;
    case "admin_statistics":
        requireRole([2]);
        $admin->statistics();
        break;
    /* ===== STUDENT ===== */
    case 'courses':
        $courseController->listForStudent();
        break;

    case 'course_detail':
        $courseController->detailForStudent();
        break;

    case 'enroll':
        requireLogin();
        $controller = new EnrollmentController();
        $course_id = $_GET['id'] ?? null;
        if ($course_id) {
            $controller->enroll($course_id);
        }
        break;

    // --- KHÓA HỌC (COURSES) ---
    case 'course_index':
        $controller = new CourseController();
        $controller->index();
        break;
    case 'course_create':
        $controller = new CourseController();
        $controller->create();
        break;
    case 'course_store':
        $controller = new CourseController();
        $controller->store();
        break;
    
    // 1. Form sửa khóa học
    case 'course_edit':
        $id = isset($_GET['id']) ? $_GET['id'] : die('Thiếu ID');
        $controller = new CourseController();
        $controller->edit($id);
        break;

    // 2. Xử lý cập nhật khóa học
    case 'course_update':
        $id = isset($_GET['id']) ? $_GET['id'] : die('Thiếu ID');
        $controller = new CourseController();
        $controller->update($id);
        break;

    // 3. Xử lý xóa khóa học
    case 'course_delete':
        $id = isset($_GET['id']) ? $_GET['id'] : die('Thiếu ID');
        $controller = new CourseController();
        $controller->delete($id);
        break;

    // --- BÀI HỌC (LESSONS)  ---
    case 'lesson_index':
        $course_id = isset($_GET['course_id']) ? $_GET['course_id'] : die('Thiếu ID khóa học');
        $controller = new LessonController();
        $controller->index($course_id);
        break;

    case 'lesson_create':
        $course_id = isset($_GET['course_id']) ? $_GET['course_id'] : die('Thiếu ID khóa học');
        $controller = new LessonController();
        $controller->create($course_id);
        break;

    case 'lesson_store':
        $controller = new LessonController();
        $controller->store(); 

    // 1. Vào trang sửa bài học
    case 'lesson_edit':
        $controller = new LessonController();
        $controller->edit();
        break;

    // 2. Xử lý cập nhật sau khi sửa
    case 'lesson_update':
        $controller = new LessonController();
        $controller->update();
        break;

    // 3. Xử lý xóa bài học
    case 'lesson_delete':
        $controller = new LessonController();
        $controller->delete();
        break;
        
    /* ===== DEFAULT ===== */
    default:
    $courseController->home();
    break;
}

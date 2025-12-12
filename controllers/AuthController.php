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
    public function adminUsers() {
    $userModel = new User();
    $users = $userModel->getAllUsers();
    require "views/admin/users/manage.php";
}

public function adminUserUpdate() {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        die("Method not allowed");
    }

    $userModel = new User();

    $id = (int)($_POST['id'] ?? 0);
    $action = $_POST['do'] ?? '';

    // không cho tự khóa mình
    if (isset($_SESSION['user']) && (int)$_SESSION['user']['id'] === $id) {
        die("Không thể tự thay đổi trạng thái/role của chính mình");
    }

    if ($action === 'toggle_active') {
        $is_active = (int)($_POST['is_active'] ?? 1);
        $userModel->setActive($id, $is_active);
        header("Location: index.php?action=admin_users");
        exit;
    }

    if ($action === 'update_role') {
        $role = (int)($_POST['role'] ?? 0);
        if (!in_array($role, [0,1,2], true)) die("Role không hợp lệ");
        $userModel->updateRole($id, $role);
        header("Location: index.php?action=admin_users");
        exit;
    }

    die("Action không hợp lệ");
    }
    public function adminCategories() {
    $categoryModel = new Category();
    $categories = $categoryModel->getAll();
    require "views/admin/categories/list.php";
}

public function adminCategoryStore() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') die("Method not allowed");

    $name = $_POST['name'] ?? '';
    $desc = $_POST['description'] ?? '';

    if ($name === '') die("Tên danh mục không được rỗng");

    $categoryModel = new Category();
    $categoryModel->create($name, $desc);

    header("Location: index.php?action=admin_categories");
}

public function adminCategoryDelete() {
    $id = (int)($_GET['id'] ?? 0);
    $categoryModel = new Category();
    $categoryModel->delete($id);
    header("Location: index.php?action=admin_categories");
}
public function adminApproveCourses() {
    $courseModel = new Course();
    $courses = $courseModel->getPendingCourses();
    require "views/admin/courses/approve.php";
}

public function adminApproveCourseAction() {
    $id = (int)($_GET['id'] ?? 0);
    $courseModel = new Course();
    $courseModel->approveCourse($id);
    header("Location: index.php?action=admin_approve_courses");
}


}

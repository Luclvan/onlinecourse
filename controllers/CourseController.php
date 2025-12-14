<?php
// controllers/CourseController.php
require_once 'models/Course.php';
require_once 'models/Category.php'; 

class CourseController {
    
    // Hiển thị danh sách khóa học của giảng viên (Read)
    public function index() {
        // Kiểm tra quyền: Phải đăng nhập và là Giảng viên (role = 1) [cite: 28]
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1) {
            header('Location: /login');
            exit();
        }

        $courseModel = new Course();
        // Lấy ID giảng viên từ Session
        $instructor_id = $_SESSION['user']['id']; 
        $courses = $courseModel->getCoursesByInstructor($instructor_id);

        // Load view
        require 'views/instructor/my_courses.php';
    }

    // Hiển thị form tạo khóa học
    public function create() {
        session_start();
        // ... (Kiểm tra quyền như trên) ...
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1) {
            header('Location: /login');
            exit();
        }
        $categoryModel = new Category();
        $categories = $categoryModel->getAll(); 

        require 'views/instructor/course/create.php';
    }

    // Xử lý lưu khóa học mới (Store)
    public function store() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $category_id = $_POST['category_id'];
            $price = $_POST['price'];
            $level = $_POST['level']; // Beginner, Intermediate, Advanced [cite: 38]
            $instructor_id = $_SESSION['user']['id'];

            // Xử lý Upload ảnh [cite: 39, 98]
            $imagePath = "";
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $targetDir = "uploads/courses/";
                // Tạo tên file duy nhất để tránh trùng
                $fileName = time() . "_" . basename($_FILES["image"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                    $imagePath = $fileName;
                }
            }

            $courseModel = new Course();
            if ($courseModel->create($title, $description, $instructor_id, $category_id, $price, $level, $imagePath)) {
                header('Location: /instructor/courses?msg=success');
            } else {
                echo "Lỗi khi tạo khóa học";
            }
        }
    }
    
    // ... Các hàm edit(), update(), delete() tương tự ...
    public function listForStudent() {
    $courseModel = new Course();

    if (!empty($_GET['keyword'])) {
        $courses = $courseModel->searchCourses($_GET['keyword']);
    } else {
        $courses = $courseModel->getAllCourses();
    }

    require 'views/courses/index.php';
}

// chi tiết khóa học
public function detailForStudent() {
    $id = $_GET['id'] ?? 0;
    $courseModel = new Course();

    $course = $courseModel->getCourseDetail($id);
    $lessons = $courseModel->getCourseLessons($id);

    require __DIR__ . '/../views/courses/detail.php';    
    }
    // Trang home cho sinh viên
public function home() {
    $courseModel = new Course();
    $courses = $courseModel->getAllCourses();
    require __DIR__ . '/../views/home/index.php';
}

}
?>

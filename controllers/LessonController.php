<?php
require_once 'models/Lesson.php';
require_once 'models/Course.php';

class LessonController {

    // Helper: Kiểm tra quyền sở hữu khóa học
    private function checkCourseOwnership($course_id) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $courseModel = new Course();
        $course = $courseModel->getCourseById($course_id);
        
        if (!$course || $course['instructor_id'] != $_SESSION['user']['id']) {
            return false;
        }
        return true;
    }

    // Hiển thị danh sách bài học của một khóa học (Manage Lessons)
    public function index($course_id) {
        if (!$this->checkCourseOwnership($course_id)) {
            die("Access Denied");
        }

        $lessonModel = new Lesson();
        $lessons = $lessonModel->getLessonsByCourse($course_id);
        
        // Truyền thêm course_id để nút "Thêm bài học" biết thêm vào đâu
        require 'views/instructor/lessons/manage.php';
    }

    // Form tạo bài học
    public function create($course_id) {
        if (!$this->checkCourseOwnership($course_id)) {
            die("Access Denied");
        }
        require 'views/instructor/lessons/create.php';
    }

    // Lưu bài học
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $course_id = $_POST['course_id'];
            
            if (!$this->checkCourseOwnership($course_id)) {
                die("Access Denied");
            }

            $title = $_POST['title'];
            $content = $_POST['content']; // Khuyến khích dùng CKEditor cho field này
            $video_url = $_POST['video_url'];
            $order = $_POST['order'];

            $lessonModel = new Lesson();
            $lessonModel->create($course_id, $title, $content, $video_url, $order);

            // Quay lại trang quản lý bài học của khóa học đó
            header("Location: /instructor/course/lessons?course_id=$course_id");
        }
    }
}
?>
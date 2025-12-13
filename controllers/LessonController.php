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
        $lessonModel = new Lesson();
        $lessons = $lessonModel->getLessonsByCourse($course_id);
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
           // Lấy dữ liệu từ Form
            $course_id = $_POST['course_id'];
            $title = $_POST['title'];
            $content = $_POST['content'];
            $video_url = $_POST['video_url'];
            $order = $_POST['order'];

            $lessonModel = new Lesson();
            // Gọi hàm create trong Model
            $result = $lessonModel->create($course_id, $title, $content, $video_url, $order);

            if ($result) {
                // QUAN TRỌNG: Chuyển hướng đúng đường dẫn
                header("Location: " . BASE_URL . "/index.php?action=lesson_index&course_id=$course_id&msg=success");
                exit();
            } else {
                echo "Lỗi: Không thể thêm bài học.";
            }
        }
    }

    // 4. HIỂN THỊ FORM SỬA BÀI HỌC
    public function edit() {
        if (!isset($_GET['id'])) die("Thiếu ID bài học");
        $id = $_GET['id'];

        $lessonModel = new Lesson();
        $lesson = $lessonModel->getLessonById($id);

        if (!$lesson) die("Bài học không tồn tại");

        // Kiểm tra quyền sở hữu (Security)
        if (!$this->checkCourseOwnership($lesson['course_id'])) {
            die("Bạn không có quyền sửa bài học này");
        }

        require 'views/instructor/lessons/edit.php';
    }

    // 5. XỬ LÝ CẬP NHẬT (UPDATE)
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_GET['id'];
            $course_id = $_POST['course_id']; // Lấy để redirect
            
            // Check quyền
            if (!$this->checkCourseOwnership($course_id)) {
                die("Access Denied");
            }

            $title = $_POST['title'];
            $content = $_POST['content'];
            $video_url = $_POST['video_url'];
            $order = $_POST['order'];

            $lessonModel = new Lesson();
            $result = $lessonModel->update($id, $title, $content, $video_url, $order);

            if ($result) {
                // Chuyển hướng về danh sách bài học
                header("Location: " . BASE_URL . "/index.php?action=lesson_index&course_id=$course_id&msg=updated");
            } else {
                echo "Lỗi cập nhật bài học";
            }
        }
    }

    // 6. XỬ LÝ XÓA (DELETE)
    public function delete() {
        if (!isset($_GET['id'])) die("Thiếu ID");
        $id = $_GET['id'];
        
        // Cần lấy course_id để quay lại trang danh sách và check quyền
        $lessonModel = new Lesson();
        $lesson = $lessonModel->getLessonById($id);
        
        if (!$lesson) die("Bài học không tồn tại");
        $course_id = $lesson['course_id'];

        // Check quyền
        if (!$this->checkCourseOwnership($course_id)) {
            die("Access Denied");
        }

        // Gọi model xóa
        if ($lessonModel->delete($id)) {
            header("Location: " . BASE_URL . "/index.php?action=lesson_index&course_id=$course_id&msg=deleted");
        } else {
            echo "Lỗi xóa bài học";
        }
    }
    
}
?>
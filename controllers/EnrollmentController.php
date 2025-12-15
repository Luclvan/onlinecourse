<?php
require_once 'models/Enrollment.php';

class EnrollmentController {

    public function enroll($course_id) {

        // 1. Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }

        // 2. Chỉ học viên được đăng ký
        if ($_SESSION['user']['role'] != 0) {
            die("Chỉ học viên mới được đăng ký khóa học");
        }

        $student_id = $_SESSION['user']['id'];
        $enrollmentModel = new Enrollment();

        // 3. Kiểm tra trùng
        if ($enrollmentModel->isEnrolled($student_id, $course_id)) {
            header("Location: index.php?action=course_detail&id=$course_id&msg=exists");
            exit;
        }

        // 4. Đăng ký
        $enrollmentModel->enroll($student_id, $course_id);

        // 5. Quay lại chi tiết khóa học
        header("Location: index.php?action=course_detail&id=$course_id&msg=success");
        exit;
    }
}

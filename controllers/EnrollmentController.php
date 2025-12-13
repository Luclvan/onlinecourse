<?php
class EnrollmentController {

    public function enroll($course_id) {
        session_start();
        if (!isset($_SESSION["user"])) {
            header("Location: /auth/login");
            exit;
        }

        $student_id = $_SESSION["user"]["id"];

        require_once "./models/Enrollment.php";
        require_once "./config/Database.php";

        $db = (new Database())->connect();
        $model = new Enrollment($db);

        if ($model->enroll($course_id, $student_id)) {
            header("Location: /student/my_courses");
        } else {
            echo "Bạn đã đăng ký khóa học này!";
        }
    }

    public function myCourses() {
        session_start();
        $student_id = $_SESSION["user"]["id"];

        require_once "./models/Enrollment.php";
        require_once "./config/Database.php";

        $db = (new Database())->connect();
        $model = new Enrollment($db);

        $myCourses = $model->getMyCourses($student_id);

        require "./views/student/my_courses.php";
    }
}

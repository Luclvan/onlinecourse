<?php
require_once __DIR__ . '/../config/Database.php';

class Enrollment {
    private $conn;
    private $table = 'enrollments';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Kiểm tra đã đăng ký chưa
    public function isEnrolled($student_id, $course_id) {
        $sql = "SELECT id FROM {$this->table}
                WHERE student_id = :student_id AND course_id = :course_id
                LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':student_id' => $student_id,
            ':course_id'  => $course_id
        ]);
        return $stmt->fetch() ? true : false;
    }

    // Đăng ký khóa học
    public function enroll($student_id, $course_id) {
        $sql = "INSERT INTO {$this->table}
                (student_id, course_id, status, progress, enrolled_date)
                VALUES (:student_id, :course_id, 'active', 0, NOW())";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':student_id' => $student_id,
            ':course_id'  => $course_id
        ]);
    }
}

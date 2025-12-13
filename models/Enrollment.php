<?php
class Enrollment {
    private $conn;
    private $table = "enrollments";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Đăng ký khóa học
    public function enroll($course_id, $student_id) {
        // Kiểm tra trùng
        $check = $this->conn->prepare("SELECT * FROM enrollments WHERE course_id = :course_id AND student_id = :student_id");
        $check->execute([
            ":course_id" => $course_id,
            ":student_id" => $student_id
        ]);
        if ($check->rowCount() > 0) return false;

        $sql = "INSERT INTO enrollments(course_id, student_id, enrolled_date, status, progress) 
                VALUES(:course_id, :student_id, NOW(), 'active', 0)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ":course_id" => $course_id,
            ":student_id" => $student_id
        ]);
    }

    // Lấy khóa học học viên đã đăng ký
    public function getMyCourses($student_id) {
        $sql = "SELECT e.*, c.title, c.image, c.level 
                FROM enrollments e
                JOIN courses c ON e.course_id = c.id
                WHERE student_id = :student_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":student_id", $student_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

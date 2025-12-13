<?php
require_once __DIR__ . '/../config/Database.php';

class Course {
    private $conn;
    private $table = 'courses';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    /* ===== INSTRUCTOR: lấy course theo giảng viên ===== */
    public function getCoursesByInstructor($instructor_id) {
        $sql = "SELECT * FROM {$this->table}
                WHERE instructor_id = :instructor_id
                ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':instructor_id' => (int)$instructor_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCourseById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => (int)$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* ===== INSTRUCTOR: tạo course (mặc định pending để admin duyệt) ===== */
    public function create($title, $description, $instructor_id, $category_id, $price, $level, $image) {
        // status = pending để admin duyệt
        $sql = "INSERT INTO {$this->table}
                (title, description, instructor_id, category_id, price, level, image, status, created_at)
                VALUES (:title, :description, :instructor_id, :category_id, :price, :level, :image, 'pending', NOW())";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':instructor_id' => (int)$instructor_id,
            ':category_id' => (int)$category_id,
            ':price' => $price,
            ':level' => $level,
            ':image' => $image
        ]);
    }

    /* ===== ADMIN: lấy danh sách pending để duyệt ===== */
    public function getPendingCourses() {
        $sql = "SELECT * FROM {$this->table}
                WHERE status = 'pending'
                ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ===== ADMIN: duyệt course ===== */
    public function approveCourse($id) {
        $sql = "UPDATE {$this->table}
                SET status = 'approved', updated_at = NOW()
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => (int)$id]);
    }

    /* (Optional) ADMIN: từ chối course */
    public function rejectCourse($id) {
        $sql = "UPDATE {$this->table}
                SET status = 'rejected', updated_at = NOW()
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => (int)$id]);
    }
    // CHANGED: sửa $this->db thành $this->conn
    public function getAllCourses() { // CHANGED
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // CHANGED: sửa $this->db thành $this->conn
    public function searchCourses($keyword) { // CHANGED
        $stmt = $this->conn->prepare(
            "SELECT * FROM {$this->table}
             WHERE title LIKE :kw OR description LIKE :kw
             ORDER BY created_at DESC"
        );
        $stmt->execute([':kw' => "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy chi tiết khóa học kèm tên giảng viên + tên danh mục
public function getCourseDetail($id) {
    $sql = "SELECT c.*,
                u.fullname AS instructor_name,
                cat.name AS category_name
            FROM courses c
            JOIN users u ON c.instructor_id = u.id
            JOIN categories cat ON c.category_id = cat.id
            WHERE c.id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Lấy danh sách bài học
public function getCourseLessons($id) {
    $sql = "SELECT * FROM lessons WHERE course_id = :id ORDER BY id ASC";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}

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

    public function rejectCourse($id) {
        $sql = "UPDATE {$this->table}
                SET status = 'rejected', updated_at = NOW()
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => (int)$id]);
    }

    public function update($id, $title, $description, $category_id, $price, $level, $image) {
        // Cập nhật thông tin cơ bản
        $sql = "UPDATE " . $this->table . " 
                SET title = :title, 
                    description = :description, 
                    category_id = :category_id, 
                    price = :price, 
                    level = :level, 
                    updated_at = NOW()";

        // Nếu có ảnh mới thì cập nhật thêm cột image
        if ($image) {
            $sql .= ", image = :image";
        }

        $sql .= " WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':level', $level);
        $stmt->bindParam(':id', $id);

        if ($image) {
            $stmt->bindParam(':image', $image);
        }

        return $stmt->execute();
    }

    // Dán vào trong class Course (models/Course.php)

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
}

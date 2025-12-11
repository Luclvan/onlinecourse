<?php

require_once __DIR__ . '/../config/Database.php';

class Course{
    private $conn;
    private $table = 'courses';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Lấy danh sách khóa học của MỘT giảng viên cụ thể
    public function getCoursesByInstructor($instructor_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE instructor_id = :instructor_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':instructor_id', $instructor_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết một khóa học
    public function getCourseById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm khóa học mới (Create)
    public function create($title, $description, $instructor_id, $category_id, $price, $level, $image) {
        $query = "INSERT INTO " . $this->table . " 
                  (title, description, instructor_id, category_id, price, level, image, created_at) 
                  VALUES (:title, :description, :instructor_id, :category_id, :price, :level, :image, NOW())";
        
        $stmt = $this->conn->prepare($query);

        // Bind dữ liệu
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':instructor_id', $instructor_id);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':level', $level);
        $stmt->bindParam(':image', $image);

        return $stmt->execute();
    }

    // Cập nhật khóa học (Update)
    public function update($id, $title, $description, $category_id, $price, $level, $image) {
        // Logic cập nhật tương tự Create, thêm WHERE id = :id
        // Nếu $image null (người dùng không đổi ảnh) thì giữ nguyên ảnh cũ
        $sql = "UPDATE " . $this->table . " SET title=:title, description=:description, category_id=:category_id, price=:price, level=:level, updated_at=NOW()";
        
        if ($image) {
            $sql .= ", image=:image";
        }
        $sql .= " WHERE id=:id";
        
        $stmt = $this->conn->prepare($sql);
        // ... Bind params ...
        return $stmt->execute();
    }

    // Xóa khóa học (Delete)
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
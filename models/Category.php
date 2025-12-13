<?php
require_once 'config/Database.php';

class Category {
    private $conn;
    private $table = 'categories';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Lấy tất cả danh mục (Dùng để hiển thị trong thẻ <select> khi tạo khóa học)
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tên danh mục theo ID (Nếu cần hiển thị tên thay vì ID)
    public function getNameById($id) {
        $query = "SELECT name FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['name'] : 'Unknown';
    }
}
?>
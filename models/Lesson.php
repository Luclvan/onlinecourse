<?php
require_once 'config/Database.php';

class Lesson {
    private $conn;
    private $table = 'lessons';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // 1. Lấy tất cả bài học thuộc về một khóa học (Sắp xếp theo thứ tự order)
    public function getLessonsByCourse($course_id) {
        // Lưu ý: chữ order là từ khóa của SQL nên cần để trong dấu backticks ` `
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE course_id = :course_id 
                  ORDER BY `order` ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Lấy thông tin chi tiết của 1 bài học (Dùng cho trang Edit hoặc trang Học)
    public function getLessonById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 3. Thêm bài học mới (Create)
    public function create($course_id, $title, $content, $video_url, $order) {
        $query = "INSERT INTO " . $this->table . " 
                  (course_id, title, content, video_url, `order`, created_at) 
                  VALUES (:course_id, :title, :content, :video_url, :order, NOW())";

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu (Optional - tùy mức độ kỹ tính, ở đây mình bind trực tiếp)
        $title = htmlspecialchars(strip_tags($title));
        $video_url = htmlspecialchars(strip_tags($video_url));

        // Gán dữ liệu vào tham số
        $stmt->bindParam(':course_id', $course_id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content); // Content thường chứa HTML nên không strip_tags
        $stmt->bindParam(':video_url', $video_url);
        $stmt->bindParam(':order', $order);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // 4. Cập nhật bài học (Update) - Hàm bạn đang bị thiếu
    public function update($id, $title, $content, $video_url, $order) {
        $query = "UPDATE " . $this->table . " 
                  SET title = :title, 
                      content = :content, 
                      video_url = :video_url, 
                      `order` = :order 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu cơ bản
        $title = htmlspecialchars(strip_tags($title));
        $video_url = htmlspecialchars(strip_tags($video_url));

        // Gán dữ liệu
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':video_url', $video_url);
        $stmt->bindParam(':order', $order);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // 5. Xóa bài học (Delete) - Hàm bạn đang bị thiếu
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
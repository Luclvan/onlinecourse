<?php
require_once __DIR__ . '/../config/Database.php';

class Category {
    private $conn;
    private $table = 'categories';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAll() {
        $stmt = $this->conn->prepare(
            "SELECT * FROM $this->table ORDER BY created_at DESC"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($name, $description) {
        $stmt = $this->conn->prepare(
            "INSERT INTO $this->table (name, description) VALUES (:name, :description)"
        );
        return $stmt->execute([
            ':name' => $name,
            ':description' => $description
        ]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare(
            "DELETE FROM $this->table WHERE id = :id"
        );
        return $stmt->execute([':id' => $id]);
    }
}

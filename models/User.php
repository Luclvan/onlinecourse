<?php
require_once "config/Database.php";

class User {
    private $conn;
    private $table = "users";

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function register($username, $email, $password, $fullname) {
        $sql = "INSERT INTO $this->table (username, email, password, fullname)
                VALUES (:username, :email, :password, :fullname)";
        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ":username" => $username,
            ":email" => $email,
            ":password" => password_hash($password, PASSWORD_BCRYPT),
            ":fullname" => $fullname
        ]);
        return true;
    }

    public function checkLogin($email, $password) {
    $sql = "SELECT * FROM $this->table WHERE email = :email LIMIT 1";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([":email" => $email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) return false;

    // NEW: chặn user bị vô hiệu hóa
    if (isset($user['is_active']) && (int)$user['is_active'] === 0) {
        return "DISABLED";
    }

    if (password_verify($password, $user["password"])) {
        return $user;
    }
    return false;
    }   
    public function getAllUsers() {
    $sql = "SELECT id, username, email, fullname, role, is_active, created_at
            FROM $this->table
            ORDER BY created_at DESC";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function setActive($id, $is_active) {
        $sql = "UPDATE $this->table SET is_active = :is_active WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':is_active' => (int)$is_active,
            ':id' => (int)$id
        ]);
    }

    public function updateRole($id, $role) {
        $sql = "UPDATE $this->table SET role = :role WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':role' => (int)$role,
            ':id' => (int)$id
        ]);
    }

}

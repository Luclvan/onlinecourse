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

        if (password_verify($password, $user["password"])) {
            return $user;
        }
        return false;
    }
}

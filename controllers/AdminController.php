<?php
require_once __DIR__ . '/../config/Database.php';

class AdminController {

    public function statistics() {
    $db = new Database();
    $conn = $db->connect();

    $stats = [
    'users' => $conn->query("SELECT COUNT(*) FROM users")->fetchColumn(),
    'courses' => $conn->query("SELECT COUNT(*) FROM courses")->fetchColumn(),
    'pending_courses' => $conn->query(
        "SELECT COUNT(*) FROM courses WHERE status = 'pending'"
    )->fetchColumn(),
    'enrollments' => $conn->query(
        "SELECT COUNT(*) FROM enrollments"
    )->fetchColumn()
];

//abc
    require "views/admin/reports/statistics.php";
}

}

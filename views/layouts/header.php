<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>OnlineCourse</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="main-header">
    <div class="container header-inner">
        <div class="logo">
            <a href="index.php" class="logo-link">OnlineCourse</a>
        </div>
        <nav class="nav">
            <a href="index.php" class="nav-link">Trang chủ</a>

            <?php if ($user): ?>

                <!-- HỌC SINH -->
                <?php if ($user['role'] == 0): ?>
                    <a href="index.php?action=student_dashboard" class="btn btn-outline">
                        Trang học viên
                    </a>
                <?php endif; ?>

                <!-- GIÁO VIÊN -->
                <?php if ($user['role'] == 1): ?>
                    <a href="index.php?action=instructor_courses" class="btn btn-outline">
                        Quản lý khóa học
                    </a>
                <?php endif; ?>

                <!-- ADMIN -->
                <?php if ($user['role'] == 2): ?>
                    <a href="index.php?action=instructor_courses" class="btn btn-outline">
                        Quản lý khóa học
                    </a>
                    <a href="index.php?action=admin_dashboard" class="btn btn-outline">
                        Admin
                    </a>
                <?php endif; ?>

                <span class="nav-user">
                    Xin chào, <strong><?= htmlspecialchars($user['fullname']) ?></strong>
                </span>

                <a href="index.php?action=logout" class="btn btn-primary">
                    Đăng xuất
                </a>

            <?php else: ?>

                <a href="index.php?action=login" class="btn btn-outline">Đăng nhập</a>
                <a href="index.php?action=register" class="btn btn-primary">Đăng ký</a>

            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="main-content">
    <div class="container">

<?php require 'views/layouts/header.php'; ?>

<h1 class="page-title">Thống kê hệ thống</h1>

<ul>
    <li>Tổng người dùng: <strong><?= $stats['users'] ?></strong></li>
    <li>Tổng khóa học: <strong><?= $stats['courses'] ?></strong></li>
    <li>Lượt đăng ký: <strong><?= $stats['enrollments'] ?></strong></li>
</ul>

<?php require 'views/layouts/footer.php'; ?>

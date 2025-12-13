<?php require 'views/layouts/header.php'; ?>

<h1>Khóa học của tôi</h1>

<a href="index.php?action=course_create" class="btn btn-primary">
    + Tạo khóa học mới
</a>

<hr>

<?php if (empty($courses)): ?>
    <p>Bạn chưa tạo khóa học nào.</p>
<?php else: ?>
    <ul>
        <?php foreach ($courses as $course): ?>
            <li>
                <strong><?= htmlspecialchars($course['title']) ?></strong>
                — <?= htmlspecialchars($course['level']) ?>
                — <?= htmlspecialchars($course['price']) ?>đ
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php require 'views/layouts/footer.php'; ?>

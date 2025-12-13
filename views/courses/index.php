<?php include __DIR__ .  '/../layouts/header.php'; ?>

<h2>Danh sách khóa học</h2>

<form method="GET" action="index.php">
    <input type="hidden" name="action" value="courses">
    <input type="text" name="keyword" placeholder="Tìm kiếm khóa học..."
           value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
    <button type="submit">Tìm kiếm</button>
</form>

<hr>

<?php if (!empty($courses)): ?>
    <?php foreach ($courses as $course): ?>
        <div class="course-item">
            <h3><?= htmlspecialchars($course['title']) ?></h3>
            <p><?= nl2br(htmlspecialchars($course['description'])) ?></p>
            <p><b>Giá:</b> <?= $course['price'] ?>đ</p>

            <a href="index.php?action=course_detail&id=<?= $course['id'] ?>">
                Xem chi tiết
            </a>
        </div>
        <hr>
    <?php endforeach; ?>
<?php else: ?>
    <p>Không có khóa học nào.</p>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
<?php require 'views/layouts/header.php'; ?>

<h1 class="page-title">Khóa học nổi bật</h1>
<p class="page-subtitle"> Đây là trang demo sau khi đăng nhập. Sau này nhóm khác sẽ đổ dữ liệu khóa học thật.</p>

<div class="course-grid">

<?php if (!empty($courses)): ?>
    <?php foreach ($courses as $course): ?>
        <div class="course-card">
            <h2 class="course-title"><?= htmlspecialchars($course['title']) ?></h2>

            <p class="course-meta">
                Giảng viên ID: <?= $course['instructor_id'] ?> • 
                Level: <?= $course['level'] ?>
            </p>

            <p class="course-meta">
                Thời lượng: <?= $course['duration'] ?> • 
                Giá: <?= number_format($course['price']) ?>đ
            </p>

            <div class="course-actions">
                <a href="index.php?action=course_detail&id=<?= $course['id'] ?>" class="btn btn-primary">
                    Xem chi tiết
                </a>
            </div>
        </div>
    <?php endforeach; ?>

<?php else: ?>
    <p>Không có khóa học nào trong cơ sở dữ liệu.</p>
<?php endif; ?>

</div>

<?php require 'views/layouts/footer.php'; ?>

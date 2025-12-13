<?php include "./views/layouts/header.php"; ?>

<h2>Khóa học của tôi</h2>

<div class="my-course-list">
    <?php foreach ($myCourses as $c): ?>
        <div class="course-item">
            <img src="/assets/uploads/courses/<?= $c['image'] ?>" width="200">
            <h3><?= $c["title"] ?></h3>
            <p>Tiến độ: <?= $c["progress"] ?>%</p>
            <a href="/lesson/course/<?= $c['course_id'] ?>">Vào học</a>
        </div>
    <?php endforeach; ?>
</div>

<?php include "./views/layouts/footer.php"; ?>

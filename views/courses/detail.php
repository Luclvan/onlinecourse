<?php include "views/layouts/header.php"; ?>

<h2><?= $course["title"] ?></h2>
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'success'): ?>
    <p style="color:green;">Đăng ký khóa học thành công!</p>
<?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'exists'): ?>
    <p style="color:red;">Bạn đã đăng ký khóa học này rồi.</p>
<?php endif; ?>
<p><b>Giảng viên:</b> <?= $course["instructor_name"] ?></p>
<p><b>Danh mục:</b> <?= $course["category_name"] ?></p>

<img src="/assets/uploads/courses/<?= $course['image'] ?>" width="350">

<h3>Mô tả</h3>
<p><?= nl2br(htmlspecialchars($course["description"])) ?></p>

<h3>Bài học</h3>
<ul>
<?php foreach ($lessons as $lesson): ?>
    <li><?= htmlspecialchars($lesson["title"]) ?></li>
<?php endforeach; ?>
</ul>

<hr>
<a href="index.php?action=enroll&id=<?= $course['id'] ?>" class="btn btn-primary">
    Đăng ký khóa học
</a>

<?php include "views/layouts/footer.php"; ?>
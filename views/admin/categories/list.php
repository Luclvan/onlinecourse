<?php require 'views/layouts/header.php'; ?>

<h1 class="page-title">Quản lý danh mục khóa học</h1>

<form method="POST" action="index.php?action=admin_category_store">
    <input name="name" placeholder="Tên danh mục" required>
    <input name="description" placeholder="Mô tả">
    <button class="btn btn-primary">Thêm</button>
</form>

<hr>

<ul>
<?php foreach ($categories as $c): ?>
    <li>
        <strong><?= htmlspecialchars($c['name']) ?></strong>
        <a href="index.php?action=admin_category_delete&id=<?= $c['id'] ?>"
           onclick="return confirm('Xóa?')">Xóa</a>
    </li>
<?php endforeach; ?>
</ul>

<?php require 'views/layouts/footer.php'; ?>

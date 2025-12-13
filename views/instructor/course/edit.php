<?php include 'views/layouts/header.php'; ?>

<div class="auth-wrapper">
    <div class="auth-card" style="max-width: 800px;">
        <h2 class="auth-title">Chỉnh sửa khóa học</h2>
        
        <form action="<?= BASE_URL ?>/index.php?action=course_update&id=<?= $course['id'] ?>" method="POST" enctype="multipart/form-data">
            
            <div class="form-group">
                <label class="form-label">Tên khóa học</label>
                <input type="text" name="title" value="<?= htmlspecialchars($course['title']) ?>" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">Danh mục</label>
                <select name="category_id" class="form-input">
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $course['category_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-input" rows="4"><?= htmlspecialchars($course['description']) ?></textarea>
            </div>

            <div style="display: flex; gap: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label class="form-label">Giá (VNĐ)</label>
                    <input type="number" name="price" value="<?= $course['price'] ?>" class="form-input" required>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label class="form-label">Trình độ</label>
                    <select name="level" class="form-input">
                        <option value="Beginner" <?= ($course['level'] == 'Beginner') ? 'selected' : '' ?>>Cơ bản</option>
                        <option value="Intermediate" <?= ($course['level'] == 'Intermediate') ? 'selected' : '' ?>>Trung cấp</option>
                        <option value="Advanced" <?= ($course['level'] == 'Advanced') ? 'selected' : '' ?>>Nâng cao</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Ảnh bìa (chọn nếu muốn đổi)</label>
                <?php if($course['image']): ?>
                    <div style="margin-bottom:5px;"><img src="<?= BASE_URL ?>/uploads/courses/<?= $course['image'] ?>" width="100"></div>
                <?php endif; ?>
                <input type="file" name="image" class="form-input">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="<?= BASE_URL ?>/index.php?action=instructor_courses" class="btn btn-outline" style="color: #666;">Hủy bỏ</a>
            </div>
        </form>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
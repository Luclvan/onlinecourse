<?php include 'views/layouts/header.php'; ?>

<div class="auth-wrapper">
    <div class="auth-card" style="max-width: 800px;">
        <h2 class="auth-title">Tạo khóa học mới</h2>
        
        <form action="<?= BASE_URL ?>/index.php?action=course_store" method="POST" enctype="multipart/form-data">
            
            <div class="form-group">
                <label class="form-label">Tên khóa học (*)</label>
                <input type="text" name="title" class="form-input" required placeholder="Nhập tên khóa học">
            </div>

            <div class="form-group">
                <label class="form-label">Danh mục (*)</label>
                <select name="category_id" class="form-input">
                    <?php if(!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">Chưa có danh mục nào</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Mô tả chi tiết</label>
                <textarea name="description" class="form-input" rows="4"></textarea>
            </div>

            <div style="display: flex; gap: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label class="form-label">Giá (VNĐ)</label>
                    <input type="number" name="price" class="form-input" required value="0">
                </div>
                <div class="form-group" style="flex: 1;">
                    <label class="form-label">Trình độ</label>
                    <select name="level" class="form-input">
                        <option value="Beginner">Cơ bản (Beginner)</option>
                        <option value="Intermediate">Trung cấp (Intermediate)</option>
                        <option value="Advanced">Nâng cao (Advanced)</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Ảnh bìa</label>
                <input type="file" name="image" class="form-input">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Lưu khóa học</button>
                <a href="<?= BASE_URL ?>/index.php?action=instructor_courses" class="btn btn-outline" style="color: #666;">Hủy bỏ</a>
            </div>
        </form>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
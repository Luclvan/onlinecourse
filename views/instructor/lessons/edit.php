<?php include 'views/layouts/header.php'; ?>

<div class="auth-wrapper">
    <div class="auth-card" style="max-width: 800px;">
        <h2 class="auth-title">Chỉnh sửa bài học</h2>
        
        <form action="<?= BASE_URL ?>/index.php?action=lesson_update&id=<?= $lesson['id'] ?>" method="POST">
            
            <input type="hidden" name="course_id" value="<?= $lesson['course_id'] ?>">

            <div class="form-group">
                <label class="form-label">Thứ tự bài học</label>
                <input type="number" name="order" class="form-input" value="<?= $lesson['order'] ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Tiêu đề</label>
                <input type="text" name="title" class="form-input" value="<?= htmlspecialchars($lesson['title']) ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Video URL</label>
                <input type="text" name="video_url" class="form-input" value="<?= htmlspecialchars($lesson['video_url']) ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Nội dung bài học</label>
                <textarea name="content" class="form-input" rows="6"><?= htmlspecialchars($lesson['content']) ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="<?= BASE_URL ?>/index.php?action=lesson_index&course_id=<?= $lesson['course_id'] ?>" class="btn btn-outline" style="color: #666;">Hủy bỏ</a>
            </div>
        </form>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
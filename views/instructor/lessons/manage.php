<?php include 'views/layouts/header.php'; ?>

<div class="container" style="padding-top: 20px;">
    <div style="margin-bottom: 20px;">
        <a href="<?= BASE_URL ?>/index.php?action=instructor_courses" style="text-decoration: none; color: #6b7280; font-size: 14px;">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách khóa học
        </a>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
        <h2 class="page-title" style="margin: 0;">Quản lý bài học (Course ID: <?= $course_id ?>)</h2>
        <a href="<?= BASE_URL ?>/index.php?action=lesson_create&course_id=<?= $course_id ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm bài học mới
        </a>
    </div>

    <div class="auth-card" style="max-width: 100%; padding: 0; overflow: hidden; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #f9fafb; text-align: left; border-bottom: 1px solid #e5e7eb;">
                <tr>
                    <th style="padding: 12px 24px; font-weight: 600; color: #374151; width: 80px;">STT</th>
                    <th style="padding: 12px 24px; font-weight: 600; color: #374151;">Tiêu đề bài học</th>
                    <th style="padding: 12px 24px; font-weight: 600; color: #374151;">Video URL</th>
                    <th style="padding: 12px 24px; font-weight: 600; color: #374151; text-align: right;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($lessons)): ?>
                    <tr>
                        <td colspan="4" style="padding: 40px; text-align: center; color: #6b7280;">
                            <i class="fas fa-inbox fa-2x" style="margin-bottom: 10px; display: block; color: #d1d5db;"></i>
                            Chưa có bài học nào được tạo.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($lessons as $lesson): ?>
                    <tr style="border-bottom: 1px solid #e5e7eb; transition: background 0.2s;">
                        <td style="padding: 16px 24px; font-weight: bold; color: #4b5563;">
                            <?= $lesson['order'] ?>
                        </td>
                        <td style="padding: 16px 24px; font-weight: 500; color: #111827;">
                            <?= htmlspecialchars($lesson['title']) ?>
                        </td>
                        <td style="padding: 16px 24px; color: #6b7280; font-size: 13px; max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <a href="<?= htmlspecialchars($lesson['video_url']) ?>" target="_blank" style="color: #2563eb; text-decoration: none;">
                                <i class="fas fa-external-link-alt"></i> <?= htmlspecialchars($lesson['video_url']) ?>
                            </a>
                        </td>
                        
                        <td style="padding: 16px 24px; text-align: right;">
                            
                            <a href="<?= BASE_URL ?>/index.php?action=lesson_edit&id=<?= $lesson['id'] ?>" 
                               class="btn btn-outline"
                               style="padding: 6px 10px; border-color: #d1d5db; color: #2563eb; margin-right: 8px;" 
                               title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <a href="<?= BASE_URL ?>/index.php?action=lesson_delete&id=<?= $lesson['id'] ?>&course_id=<?= $course_id ?>" 
                               class="btn btn-outline"
                               onclick="return confirm('Cảnh báo: Bạn có chắc chắn muốn xóa bài học này không?')" 
                               style="padding: 6px 10px; border-color: #fca5a5; color: #dc2626;" 
                               title="Xóa bài học">
                                <i class="fas fa-trash-alt"></i>
                            </a>

                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
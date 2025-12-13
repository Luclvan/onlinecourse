<?php include 'views/layouts/header.php'; ?>

<div class="container" style="padding-top: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
        <div>
            <h2 class="page-title" style="margin: 0;">Khóa học của tôi</h2>
            <p class="page-subtitle" style="margin: 5px 0 0; color: #666;">Quản lý các khóa học bạn đang giảng dạy</p>
        </div>
        <a href="<?= BASE_URL ?>/index.php?action=course_create" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Tạo khóa học mới
        </a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 25px; border: 1px solid #a7f3d0;">
            <i class="fas fa-check-circle"></i> 
            <?php 
                if($_GET['msg'] == 'success') echo "Thêm khóa học thành công!";
                elseif($_GET['msg'] == 'updated') echo "Cập nhật thành công!";
                elseif($_GET['msg'] == 'deleted') echo "Đã xóa khóa học!";
            ?>
        </div>
    <?php endif; ?>

    <div class="course-grid">
        <?php if (empty($courses)): ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 50px; background: #fff; border-radius: 10px;">
                <i class="fas fa-folder-open fa-3x" style="color: #ccc; margin-bottom: 15px;"></i>
                <p>Bạn chưa có khóa học nào.</p>
                <a href="<?= BASE_URL ?>/index.php?action=course_create" style="color: #2563eb; font-weight: bold;">Tạo khóa học đầu tiên ngay!</a>
            </div>
        <?php else: ?>
            <?php foreach ($courses as $course): ?>
                <div class="course-card">
                    
                    <div style="height: 180px; background: #f3f4f6; border-radius: 8px; overflow: hidden; margin-bottom: 15px; position: relative; border: 1px solid #eee;">
                        
                        <?php if (!empty($course['image'])): ?>
                            <img src="<?= BASE_URL ?>/uploads/courses/<?= $course['image'] ?>" 
                                 style="width: 100%; height: 100%; object-fit: cover;"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"> 
                                 <?php endif; ?>

                        <div style="display: <?= !empty($course['image']) ? 'none' : 'flex' ?>; flex-direction: column; align-items: center; justify-content: center; height: 100%; color: #9ca3af;">
                            <i class="fas fa-image fa-3x"></i>
                            <span style="font-size: 12px; margin-top: 5px;">No Image</span>
                        </div>

                        <?php if(isset($course['status'])): ?>
                            <span style="position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.7); color: #fff; padding: 4px 8px; border-radius: 4px; font-size: 11px;">
                                <?= ucfirst($course['status']) ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <h3 class="course-title" style="font-size: 18px; margin-bottom: 10px; line-height: 1.4; height: 50px; overflow: hidden;">
                        <?= htmlspecialchars($course['title']) ?>
                    </h3>
                    
                    <div class="course-meta" style="font-size: 14px; color: #555; display: flex; justify-content: space-between; margin-bottom: 15px;">
                        <span style="color: #dc2626; font-weight: bold;">
                            <i class="fas fa-tag"></i> <?= number_format($course['price'], 0, ',', '.') ?> đ
                        </span>
                        <span style="background: #e5e7eb; padding: 2px 8px; border-radius: 12px; font-size: 12px;">
                            <i class="fas fa-layer-group"></i> <?= $course['level'] ?>
                        </span>
                    </div>
                    
                    <div class="course-actions" style="display: flex; gap: 10px; border-top: 1px solid #eee; padding-top: 15px;">
                        <a href="<?= BASE_URL ?>/index.php?action=lesson_index&course_id=<?= $course['id'] ?>" class="btn btn-primary" style="flex: 1; text-align: center; font-size: 13px;">
                            <i class="fas fa-list-ul"></i> QL Bài học
                        </a>
                        
                        <a href="<?= BASE_URL ?>/index.php?action=course_edit&id=<?= $course['id'] ?>" class="btn btn-outline" style="padding: 6px 10px; color: #4b5563; border-color: #d1d5db;" title="Sửa khóa học">
                            <i class="fas fa-edit"></i>
                        </a>

                        <a href="<?= BASE_URL ?>/index.php?action=course_delete&id=<?= $course['id'] ?>" onclick="return confirm('CẢNH BÁO:\nXóa khóa học sẽ xóa toàn bộ bài học bên trong!\nBạn có chắc chắn muốn xóa?')" class="btn btn-outline" style="padding: 6px 10px; color: #ef4444; border-color: #fca5a5;" title="Xóa khóa học">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
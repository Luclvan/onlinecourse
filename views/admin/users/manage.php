<?php require 'views/layouts/header.php'; ?>

<h1 class="page-title">Quản lý người dùng</h1>
<p class="page-subtitle">Admin có thể đổi role và vô hiệu hóa tài khoản.</p>

<table style="width:100%; border-collapse: collapse; background:#fff; border-radius:12px; overflow:hidden;">
    <thead>
        <tr style="text-align:left; background:#f3f4f6;">
            <th style="padding:10px; border-bottom:1px solid #e5e7eb;">ID</th>
            <th style="padding:10px; border-bottom:1px solid #e5e7eb;">Fullname</th>
            <th style="padding:10px; border-bottom:1px solid #e5e7eb;">Email</th>
            <th style="padding:10px; border-bottom:1px solid #e5e7eb;">Role</th>
            <th style="padding:10px; border-bottom:1px solid #e5e7eb;">Trạng thái</th>
            <th style="padding:10px; border-bottom:1px solid #e5e7eb;">Hành động</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $u): ?>
        <tr>
            <td style="padding:10px; border-bottom:1px solid #e5e7eb;"><?= (int)$u['id'] ?></td>
            <td style="padding:10px; border-bottom:1px solid #e5e7eb;"><?= htmlspecialchars($u['fullname'] ?? '') ?></td>
            <td style="padding:10px; border-bottom:1px solid #e5e7eb;"><?= htmlspecialchars($u['email'] ?? '') ?></td>

            <td style="padding:10px; border-bottom:1px solid #e5e7eb;">
                <form action="index.php?action=admin_user_update" method="POST" style="display:flex; gap:8px; align-items:center;">
                    <input type="hidden" name="do" value="update_role">
                    <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
                    <select name="role">
                        <option value="0" <?= ((int)$u['role']===0?'selected':'') ?>>Học viên</option>
                        <option value="1" <?= ((int)$u['role']===1?'selected':'') ?>>Giảng viên</option>
                        <option value="2" <?= ((int)$u['role']===2?'selected':'') ?>>Admin</option>
                    </select>
                    <button class="btn btn-outline" type="submit">Đổi role</button>
                </form>
            </td>

            <td style="padding:10px; border-bottom:1px solid #e5e7eb;">
                <?= ((int)$u['is_active']===1) ? "Đang hoạt động" : "Bị vô hiệu hóa" ?>
            </td>

            <td style="padding:10px; border-bottom:1px solid #e5e7eb;">
                <form action="index.php?action=admin_user_update" method="POST">
                    <input type="hidden" name="do" value="toggle_active">
                    <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
                    <input type="hidden" name="is_active" value="<?= ((int)$u['is_active']===1)?0:1 ?>">
                    <button class="btn btn-primary" type="submit">
                        <?= ((int)$u['is_active']===1) ? "Vô hiệu hóa" : "Kích hoạt" ?>
                    </button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php require 'views/layouts/footer.php'; ?>

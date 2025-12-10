<!-- <form action="index.php?action=loginPost" method="POST">
    <input name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Đăng nhập</button>
</form> -->

<?php require 'views/layouts/header.php'; ?>

<div class="auth-wrapper">
    <div class="auth-card">
        <h1 class="auth-title">Đăng nhập</h1>
        <p class="auth-subtitle">Truy cập hệ thống khóa học online</p>

        <form action="index.php?action=loginPost" method="POST">
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-input"
                    placeholder="nhapemail@vidu.com"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Mật khẩu</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-input"
                    placeholder="••••••••"
                    required
                >
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" style="width:100%">
                    Đăng nhập
                </button>
            </div>
        </form>

        <div class="auth-extra">
            Chưa có tài khoản?
            <a href="index.php?action=register">Đăng ký ngay</a>
        </div>
    </div>
</div>

<?php require 'views/layouts/footer.php'; ?>

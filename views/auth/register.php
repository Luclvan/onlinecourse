<!-- <form action="index.php?action=registerPost" method="POST">
    <input name="username" placeholder="Username" required>
    <input name="fullname" placeholder="Full name" required>
    <input name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Đăng ký</button>
</form> -->

<?php require 'views/layouts/header.php'; ?>

<div class="auth-wrapper">
    <div class="auth-card">
        <h1 class="auth-title">Đăng ký</h1>
        <p class="auth-subtitle">Tạo tài khoản để bắt đầu học</p>

        <form action="index.php?action=registerPost" method="POST">
            <div class="form-group">
                <label class="form-label" for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    class="form-input"
                    placeholder="vd: nguyenvana"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="fullname">Họ và tên</label>
                <input
                    type="text"
                    id="fullname"
                    name="fullname"
                    class="form-input"
                    placeholder="Nguyễn Văn A"
                    required
                >
            </div>

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
                    Đăng ký
                </button>
            </div>
        </form>

        <div class="auth-extra">
            Đã có tài khoản?
            <a href="index.php?action=login">Đăng nhập</a>
        </div>
    </div>
</div>

<?php require 'views/layouts/footer.php'; ?>

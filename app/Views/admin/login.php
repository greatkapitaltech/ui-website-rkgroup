<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>RK Group - Admin Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Favicon -->
<link rel="icon" type="image/svg+xml" href="<?=base_url('/assets/img/RKGroup logo.svg')?>">

<!-- Google Font - Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Sweet Alert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #00679E 0%, #2F59A7 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.login-container {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    padding: 50px 40px;
    max-width: 420px;
    width: 100%;
}

.logo-container {
    text-align: center;
    margin-bottom: 40px;
}

.logo-container img {
    max-width: 200px;
    height: auto;
}

.login-title {
    font-size: 28px;
    font-weight: 600;
    color: #2C3E50;
    text-align: center;
    margin-bottom: 10px;
}

.login-subtitle {
    font-size: 14px;
    color: #7f8c8d;
    text-align: center;
    margin-bottom: 35px;
}

.form-group {
    margin-bottom: 25px;
}

.form-label {
    display: block;
    font-size: 14px;
    font-weight: 500;
    color: #2C3E50;
    margin-bottom: 8px;
}

.form-control {
    width: 100%;
    padding: 14px 18px;
    font-size: 15px;
    font-family: 'Poppins', sans-serif;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    transition: all 0.3s ease;
    outline: none;
}

.form-control:focus {
    border-color: #00679E;
    box-shadow: 0 0 0 3px rgba(0, 103, 158, 0.1);
}

.btn-login {
    width: 100%;
    padding: 15px;
    font-size: 16px;
    font-weight: 600;
    font-family: 'Poppins', sans-serif;
    color: #ffffff;
    background: linear-gradient(135deg, #00679E 0%, #2F59A7 100%);
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 10px;
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 103, 158, 0.3);
}

.btn-login:active {
    transform: translateY(0);
}

.footer-text {
    text-align: center;
    margin-top: 30px;
    font-size: 13px;
    color: #95a5a6;
}

/* Error/Success alerts styling */
.swal-modal {
    font-family: 'Poppins', sans-serif;
}

/* Responsive */
@media (max-width: 480px) {
    .login-container {
        padding: 40px 30px;
    }

    .login-title {
        font-size: 24px;
    }

    .logo-container img {
        max-width: 160px;
    }
}
</style>

</head>
<body>

<div class="login-container">
    <div class="logo-container">
        <img src="<?=base_url('/assets/img/RKGroup logo.svg')?>" alt="RK Group">
    </div>

    <h1 class="login-title">Welcome Back</h1>
    <p class="login-subtitle">Sign in to access the admin panel</p>

    <form action="<?=base_url('admin/login-submit')?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-group">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="userid" placeholder="Enter your username" required autofocus>
        </div>

        <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
        </div>

        <button type="submit" class="btn-login">Sign In</button>
    </form>

    <p class="footer-text">© <?= date('Y') ?> RK Group. All rights reserved.</p>
</div>

</body>
</html>

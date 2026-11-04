<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Arusuvai </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
:root {
    --primary: #1e40af;
    --primary-dark: #1e3a8a;
    --gray: #6b7280;
}

* {
    box-sizing: border-box;
    font-family: "Segoe UI", Tahoma, sans-serif;
}

body {
    margin: 0;
    min-height: 100vh;
    background:
        linear-gradient(rgba(15,23,42,0.65), rgba(15,23,42,0.65)),
        url("admin/assets/images/bg-login.jpeg");
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

/* Card */
.auth-card {
    background: #ffffff;
    width: 100%;
    max-width: 420px;
    border-radius: 14px;
    padding: 32px;
    box-shadow: 0 25px 60px rgba(0,0,0,0.25);
}

/* Header */
.auth-card h2 {
    text-align: center;
    margin-bottom: 6px;
    color: #0f172a;
}

.auth-card p {
    text-align: center;
    color: var(--gray);
    font-size: 14px;
    margin-bottom: 24px;
}

/* Form */
.form-group {
    margin-bottom: 18px;
}

.form-group label {
    font-size: 13px;
    color: #374151;
    margin-bottom: 6px;
    display: block;
}

.form-group input {
    width: 100%;
    padding: 12px 14px;
    border-radius: 8px;
    border: 1px solid #d1d5db;
    outline: none;
    font-size: 14px;
}

.form-group input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 2px rgba(30,64,175,0.15);
}

/* Button */
.btn {
    width: 100%;
    padding: 13px;
    border: none;
    border-radius: 8px;
    background: var(--primary);
    color: #ffffff;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

.btn:hover {
    background: var(--primary-dark);
}

/* Footer */
.footer-text {
    text-align: center;
    font-size: 14px;
    margin-top: 18px;
    color: var(--gray);
}

.footer-text a {
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
}

/* Mobile */
@media (max-width: 480px) {
    .auth-card {
        padding: 24px;
    }
}
</style>
</head>

<body>

<div class="auth-card">
    <h2>Arusuvai Login</h2>
    

    <form method="POST" action="login">
        @csrf

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="example@gmail.com" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="********" required>
        </div>

        <button type="submit" class="btn">Login</button>
    </form>

    <div class="footer-text">
        Don’t have an account?
        <a href="/register">Register</a>
    </div>
</div>

</body>
</html>

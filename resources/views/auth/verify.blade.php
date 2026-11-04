<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Verify Account</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
:root {
    --primary: #2563eb;
    --primary-dark: #1e40af;
    --gray: #6b7280;
}

* {
    box-sizing: border-box;
    font-family: "Inter", "Segoe UI", sans-serif;
}

body {
    margin: 0;
    min-height: 100vh;
    background:
        linear-gradient(rgba(15,23,42,0.65), rgba(15,23,42,0.65)),
        url("https://images.unsplash.com/photo-1524995997946-a1c2e315a42f");
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Card */
.verify-card {
    background: #ffffff;
    width: 100%;
    max-width: 420px;
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 25px 60px rgba(0,0,0,0.25);
}

.verify-card h2 {
    text-align: center;
    margin-bottom: 6px;
    color: #0f172a;
}

.verify-card p {
    text-align: center;
    font-size: 14px;
    color: var(--gray);
    margin-bottom: 22px;
}

/* Inputs */
.form-group {
    margin-bottom: 18px;
}

.form-group label {
    font-size: 13px;
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
    box-shadow: 0 0 0 2px rgba(37,99,235,0.15);
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
}

.btn:hover {
    background: var(--primary-dark);
}

/* Alerts */
.alert {
    padding: 10px;
    border-radius: 6px;
    font-size: 13px;
    margin-bottom: 15px;
}

.alert-success {
    background: #dcfce7;
    color: #166534;
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
}
</style>
</head>

<body>

<div class="verify-card">
    <h2>Verify Your Account</h2>
    <p>Enter the OTP sent to your email & phone</p>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ url('verify') }}">
        @csrf

        <div class="form-group">
            <label>Email OTP</label>
            <input type="text" name="email_otp" placeholder="Enter email OTP" required>
        </div>

        <div class="form-group">
            <label>Phone OTP</label>
            <input type="text" name="phone_otp" placeholder="Enter phone OTP" required>
        </div>

        <button type="submit" class="btn">Verify Account</button>
    </form>
</div>

</body>
</html>

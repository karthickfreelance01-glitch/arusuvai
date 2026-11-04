<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Faculty Registration</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
:root {
    --primary: #2563eb;
    --primary-dark: #1e40af;
    --dark: #0f172a;
    --gray: #64748b;
    --border: #e5e7eb;
}

* {
    box-sizing: border-box;
    font-family: "Inter", "Segoe UI", sans-serif;
}

body {
    margin: 0;
    min-height: 100vh;
    background:
        linear-gradient(rgba(15,23,42,0.6), rgba(15,23,42,0.6)),
        url("https://images.unsplash.com/photo-1524995997946-a1c2e315a42f");
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Layout */
.auth-wrapper {
    width: 100%;
    max-width: 900px;
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 25px 60px rgba(15,23,42,0.2);
    display: grid;
    grid-template-columns: 1fr 1fr;
}

/* Left Panel */
.auth-info {
    background: linear-gradient(135deg, #1e3a8a, #2563eb);
    color: #ffffff;
    padding: 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.auth-info h1 {
    font-size: 28px;
    margin-bottom: 14px;
}

.auth-info p {
    font-size: 15px;
    line-height: 1.6;
}

/* Right Panel */
.auth-form {
    padding: 40px;
}

.auth-form h2 {
    margin: 0;
    font-size: 22px;
    color: var(--dark);
}

.auth-form p {
    margin: 6px 0 24px;
    font-size: 14px;
    color: var(--gray);
}

/* Inputs */
.field {
    position: relative;
    margin-bottom: 22px;
}

.field input {
    width: 100%;
    padding: 14px;
    font-size: 14px;
    border-radius: 10px;
    border: 1px solid var(--border);
    outline: none;
}

.field label {
    position: absolute;
    top: 50%;
    left: 14px;
    transform: translateY(-50%);
    background: #fff;
    padding: 0 6px;
    font-size: 13px;
    color: var(--gray);
    transition: 0.2s;
    pointer-events: none;
}

.field input:focus {
    border-color: var(--primary);
}

.field input:focus + label,
.field input:not(:placeholder-shown) + label {
    top: -7px;
    font-size: 12px;
    color: var(--primary);
}

.error {
    font-size: 12px;
    color: #dc2626;
    margin-top: 4px;
}

/* Button */
.btn {
    width: 100%;
    padding: 14px;
    border-radius: 10px;
    border: none;
    background: var(--primary);
    color: #fff;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
}

.btn:hover {
    background: var(--primary-dark);
}

/* Footer */
.form-footer {
    margin-top: 18px;
    text-align: center;
    font-size: 14px;
    color: var(--gray);
}

.form-footer a {
    color: var(--primary);
    font-weight: 600;
    text-decoration: none;
}

/* Mobile */
@media (max-width: 900px) {
    .auth-wrapper {
        grid-template-columns: 1fr;
    }
    .auth-info {
        display: none;
    }
}
</style>
</head>

<body>

<div class="auth-wrapper">

    <!-- LEFT -->
    <div class="auth-info">
        <h1>Faculty Portal</h1>
        <p>
            Secure institutional access for faculty members.<br><br>
            Register using a verified Gmail account and mobile number.
        </p>
    </div>

    <!-- RIGHT -->
    <div class="auth-form">
        <h2>Create Account</h2>
        <p>Faculty registration with verification</p>

        <form method="POST" action="register" onsubmit="return validateForm()">
            @csrf

            <div class="field">
                <input type="text" name="name" required placeholder=" ">
                <label>Full Name</label>
            </div>

            <div class="field">
                <input type="email" id="email" name="email" required placeholder=" ">
                <label>Email Address</label>
                <span class="error" id="emailError"></span>
            </div>

            <div class="field">
                <input type="text" id="phone" name="phone"
                       required placeholder=" "
                       maxlength="10" inputmode="numeric">
                <label>Mobile Number</label>
                <span class="error" id="phoneError"></span>
            </div>

            <div class="field">
                <input type="password" name="password" required placeholder=" ">
                <label>Password</label>
            </div>

            <button type="submit" class="btn">Create Account</button>
        </form>

        <div class="form-footer">
            Already registered?
            <a href="/login">Login</a>
        </div>
    </div>

</div>

<script>
const emailInput = document.getElementById('email');
const phoneInput = document.getElementById('phone');

emailInput.addEventListener('input', validateEmail);
phoneInput.addEventListener('input', validatePhone);

function validateEmail() {
    const email = emailInput.value.trim();
    const error = document.getElementById('emailError');
    const gmail = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;

    error.innerText = email && !gmail.test(email)
        ? 'Only Gmail address is allowed'
        : '';
}

function validatePhone() {
    let phone = phoneInput.value.replace(/\D/g, '');
    phoneInput.value = phone;

    const error = document.getElementById('phoneError');

    if (!phone) {
        error.innerText = '';
    } else if (phone.length < 10) {
        error.innerText = 'Mobile number must be 10 digits';
    } else if (!/^[6-9]/.test(phone)) {
        error.innerText = 'Number must start with 6, 7, 8 or 9';
    } else {
        error.innerText = '';
    }
}

function validateForm() {
    validateEmail();
    validatePhone();

    return (
        document.getElementById('emailError').innerText === '' &&
        document.getElementById('phoneError').innerText === ''
    );
}
</script>

</body>
</html>

<?php
require 'db.php';
session_start();

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($name) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $error = "Email already registered.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$name, $email, $hashed_password])) {
                $success = "Registration successful! Redirecting to login...";
                header("refresh:2;url=login.php");
            } else {
                $error = "Something went wrong.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | IQ Test</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="glass-card">
            <h2 style="text-align: center; margin-bottom: 20px; color: var(--neon-blue);">Create Account</h2>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" required placeholder="Enter your name">
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required placeholder="name@example.com">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="Create a password">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
            </form>
            <p style="text-align: center; margin-top: 20px; font-size: 0.9rem;">
                Already have an account? <a href="login.php" style="color: var(--neon-pink);">Login here</a>
            </p>
            <div style="text-align: center; margin-top: 15px;">
                <a href="index.php"
                    style="color: rgba(255,255,255,0.5); text-decoration: none; font-size: 0.8rem;">&larr; Back to
                    Home</a>
            </div>
        </div>
    </div>
</body>

</html>

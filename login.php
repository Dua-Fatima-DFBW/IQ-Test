<?php
require 'db.php';
session_start();

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $stmt = $pdo->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: quiz.php");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | IQ Test</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="glass-card">
            <h2 style="text-align: center; margin-bottom: 20px; color: var(--neon-blue);">Welcome Back</h2>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required placeholder="name@example.com">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="Enter your password">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
            <p style="text-align: center; margin-top: 20px; font-size: 0.9rem;">
                Don't have an account? <a href="signup.php" style="color: var(--neon-pink);">Sign up here</a>
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

session_start();
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IQ Test | Unlock Your Potential</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <h1>IQ TEST PRO</h1>
        <p class="subtitle">Discover your cognitive potential with recent standards of matrix reasoning and pattern
            recognition. 15 Questions. 100% Free.</p>

        <div class="glass-card" style="text-align: center; max-width: 600px;">
            <div style="margin-bottom: 30px;">
                <svg width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="var(--neon-blue)" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2a10 10 0 1 0 10 10H12V2z"></path>
                    <path d="M12 2a10 10 0 0 0-10 10h10V2z"></path>
                    <path d="M12 12l9.3-5.3"></path>
                    <path d="M12 12l-9.3-5.3"></path>
                </svg>
            </div>

            <?php if (isset($_SESSION['user_id'])): ?>
                <h2 style="margin-bottom: 20px;">Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
                <a href="quiz.php" class="btn btn-primary btn-block">Start Test Now</a>
                <br>
                <a href="logout.php" class="btn btn-secondary" style="font-size: 0.9rem;">Logout</a>
            <?php else: ?>
                <div style="display: flex; gap: 15px; justify-content: center;">
                    <a href="login.php" class="btn btn-primary">Login</a>
                    <a href="signup.php" class="btn btn-secondary">Sign Up</a>
                </div>
                <p style="margin-top: 20px; font-size: 0.9rem; opacity: 0.7;">Take the first step to knowing yourself.</p>
                <a href="quiz.php"
                    style="color: var(--neon-blue); margin-top: 10px; display: inline-block; text-decoration: none; border-bottom: 1px dashed var(--neon-blue);">Take
                    test as Guest</a>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>

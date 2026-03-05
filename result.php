<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$answers_key = [
    1 => "32",
    2 => "False",
    3 => "Carrot",
    4 => "13",
    5 => "Branch",
    6 => "Cube",
    7 => "Ocean",
    8 => "3",
    9 => "12",
    10 => "1 hour",
    11 => "70",
    12 => "Daughter",
    13 => "9",
    14 => "They don't",
    15 => "10"
];

$score = 0;
$total = count($answers_key);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($answers_key as $id => $correct_ans) {
        if (isset($_POST["q$id"]) && $_POST["q$id"] === $correct_ans) {
            $score++;
        }
    }

    // Save to DB
    try {
        $stmt = $pdo->prepare("INSERT INTO test_results (user_id, score) VALUES (?, ?)");
        $stmt->execute([$_SESSION['user_id'], $score]);
    } catch (Exception $e) {
        // Ignore error if insert fails, just show result
    }
} else {
    // If accessed directly without post, maybe show last result or redirect?
    // We will just redirect to quiz for now or show 0.
    if (!isset($_POST['q1'])) {
        header("Location: quiz.php");
        exit;
    }
}

// Determine Feedback
$feedback = "";
$badge_color = "";
if ($score <= 5) {
    $feedback = "Needs Improvement";
    $badge_color = "#ff5555";
} elseif ($score <= 10) {
    $feedback = "Average Reasoning";
    $badge_color = "#ffff55"; // Yellow
} else {
    $feedback = "High Logical Intelligence";
    $badge_color = "#55ff55"; // Green
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your IQ Result</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="glass-card" style="text-align: center;">
            <h2 style="color: var(--neon-blue); margin-bottom: 20px;">Test Complete</h2>

            <div class="result-score">
                <?php echo $score; ?> <span style="font-size: 2rem; color: white;">/
                    <?php echo $total; ?>
                </span>
            </div>

            <h3 class="result-feedback"
                style="color: <?php echo $badge_color; ?>; text-shadow: 0 0 15px <?php echo $badge_color; ?>;">
                <?php echo $feedback; ?>
            </h3>

            <p style="margin-bottom: 30px; opacity: 0.8;">
                <?php
                if ($score >= 11)
                    echo "Exceptional! Your pattern recognition skills are top-tier.";
                elseif ($score >= 6)
                    echo "Great job! You have solid logical reasoning skills.";
                else
                    echo "Keep practicing! Logic puzzles can help sharpen your mind.";
                ?>
            </p>

            <a href="quiz.php" class="btn btn-secondary">Retake Test</a>
            <a href="index.php?logout=true" class="btn btn-primary" style="margin-top: 10px;">Logout</a>
        </div>
    </div>

    <!-- Celebration Effect for high scores -->
    <?php if ($score >= 6): ?>
        <script>
            confetti({
                particleCount: 150,
                spread: 70,
                origin: { y: 0.6 },
                colors: ['#00f3ff', '#ff00ff', '#bc13fe']
            });
        </script>
    <?php endif; ?>
</body>

</html>

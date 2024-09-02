<?php
session_start(); // Ensure the session is started

// Function to sanitize output
function sanitize_output($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap');

        body {
            font-family: 'Ubuntu', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #ff6f61, #d83a56);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }

        .error_container {
            background: #fff;
            color: #333;
            width: 90%;
            max-width: 450px;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .error_container h1 {
            font-size: 36px;
            margin-bottom: 20px;
            color: #d83a56;
            animation: bounce 1s infinite;
        }

        .error_container p {
            font-size: 18px;
            margin-bottom: 30px;
            color: #333;
        }

        .back-button {
            background: #d83a56;
            color: #fff;
            padding: 12px 25px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s, transform 0.3s;
        }

        .back-button:hover {
            background-color: #b03a3a;
            transform: scale(1.05);
        }

        .confetti {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('confetti.png') no-repeat center center;
            background-size: cover;
            opacity: 0.6;
            pointer-events: none;
            animation: confetti-fall 5s linear infinite;
        }

        @keyframes confetti-fall {
            0% { transform: translateY(-100%); }
            100% { transform: translateY(100%); }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-30px);
            }
            60% {
                transform: translateY(-15px);
            }
        }
    </style>
</head>
<body>
    <div class="error_container">
        <div class="confetti"></div>
        <h1>Oops!</h1>
        <?php if (isset($_SESSION['error_message'])): ?>
            <p><?php echo sanitize_output($_SESSION['error_message']); ?></p>
            <?php unset($_SESSION['error_message']); ?>
        <?php else: ?>
            <p>An unexpected error occurred. Please try again later.</p>
        <?php endif; ?>
        <a href="index.php" class="back-button">Go Back</a>
    </div>
</body>
</html>

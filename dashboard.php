<?php
session_start();

// Sanitize session variables
function sanitize_output($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// Helper function to display array data in a user-friendly way
function display_array($array) {
    if (!is_array($array)) {
        return '<p>Data is not available.</p>';
    }
    $html = '<div class="array-output">';
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $html .= '<div class="array-item">';
            $html .= '<strong>' . sanitize_output($key) . ':</strong>';
            $html .= '<div class="array-inner">';
            $html .= display_array($value);
            $html .= '</div>';
            $html .= '</div>';
        } else {
            $html .= '<div class="array-item">';
            $html .= '<strong>' . sanitize_output($key) . ':</strong> ' . sanitize_output($value);
            $html .= '</div>';
        }
    }
    $html .= '</div>';
    return $html;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="assests/style.css"> 
    
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <style>
        body {
            background:url('assests/bg.jpeg');
            background-repeat: no-repeat;
            /* background-size: cover; */
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }
        
        .container {
            background: whitesmoke;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px 30px;
            max-width: 600px;
            width: 100%;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }
        .dash_con{
            display: flex;
            justify-content: space-between;
            padding: 10px 10px;
            align-items: center;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }
        h2 {
            color: #555;
            margin: 10px 0;
            font-size: 20px;
        }
        a {
            text-decoration: none;
            color: #007bff;
            font-size: 18px;
            transition: color 0.3s ease;
        }
        a:hover {
            color: #0056b3;
        }
        p {
            color: #28a745;
            font-size: 18px;
            margin: 20px 0;
        }
        .session_data{
            text-align: left;
        }
        .logout-icon {
            color: white;
            font-size: 15px;
            text-decoration: none;
            background: red;
            transition: color 0.3s ease;
            padding: 7px 10px;
            border-radius: 100px;
        }
        .logout-icon:hover {
            color: yellow;
        }
        .success-message {
            /* background-image: linear-gradient( 89.5deg,  rgba(131,204,255,1) 0.4%, rgba(66,144,251,1) 100.3% ); */
            background-image: linear-gradient( 90.1deg,  rgba(84,212,228,1) 0.2%, rgba(68,36,164,1) 99.9% );
            /* border: 1px solid #c3e6cb; */
            border-radius: 4px;
            padding: 10px;
            margin: 20px 0;
            animation: slideIn 1s ease-out;
        }
        .success-message p{
            color: whitesmoke !important;

        }
        .array-output {
            text-align: left;
            padding: 10px;
            /* border: 1px solid #ddd; */
            border-radius: 4px;
            background: #f9f9f9;
            margin-top: 20px;
            overflow-x: auto;
            /* box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset; */
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
        }
        .array-item {
            margin-bottom: 10px;
        }
        .array-item strong {
            display: block;
            color: #007bff;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="dash_con">
        <h1><?php echo sanitize_output($_SESSION['name'] ?? ''); ?>, Welcome to Your Dashboard 🎉</h1>
        <a href="logout.php" class="logout-icon" title="Log out"><i class="fa fa-power-off"></i></a>
        </div>

        <!-- Debug output for session data -->
        <?php if(isset($_SESSION['success_data'])): ?>
            <h2 class="session_data">Session Data</h2>
            <?php echo display_array($_SESSION['success_data']); ?>
        <?php endif; ?>

        <!-- Display the success message -->
        <?php if(isset($_SESSION['success_data']) && isset($_SESSION['success_data']['message'])): ?>
            <div class="success-message">
                <p><?php echo sanitize_output($_SESSION['success_data']['message']); ?></p>
            </div>
        <?php else: ?>
            <p>No success message found.</p>
        <?php endif; ?>
    </div>
</body>
</html>

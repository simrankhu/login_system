<?php
session_start(); // Start the session

// For debugging, print the current session data
// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';

// store token in variable
$token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOjc5LCJleHAiOjE3MjYzMjg3NzksImlhdCI6MTcyNTM0NDgxNX0.7IvxUgbZtXZAT29LsVLJ-qcdP0VX_ICm8yEZpD3YTbQ'; 

// Store token in session
$_SESSION['token'] = $token;

// Output the token to verify it's being set
// echo 'Token has been set: ' . $_SESSION['token'] . '<br>';

// Fetch the access token from the session
$access_token = $_SESSION['token'];
if (empty($access_token)) { 
    // Check if the access token is present in the session
    echo "Access token not found in session. Please verify OTP first.<br>";
    exit; // If the access token is missing, stop further execution
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data from the POST request
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $company = $_POST['company'] ?? '';
    $state = $_POST['state'] ?? '';
    $city = $_POST['city'] ?? '';
    $sponsor_code = $_POST['sponsorC'] ?? '';

    // Prepare data for the request body by encoding it as JSON
    $data = json_encode([
        "name" => $name,
        "email" => $email,
        "company" => $company,
        "state" => $state,
        "city" => $city,
        "sponsor_code" => $sponsor_code
    ]);
    $_SESSION['name']=$name;

    // Set up the HTTP headers and options for the POST request
    $options = [
        "http" => [
            "header" => "Content-Type: application/json\r\n" .  
                        "Authorization: Bearer " . trim($access_token) . "\r\n" . 
                        "device-type: Mobile\r\n", 
            "method" => "POST", 
            "content" => $data, 
        ],
        "ssl" => [
            "verify_peer" => false,
            "verify_peer_name" => false,
        ]
    ];
    $url = 'http://185.193.19.48:9080/api/v1/create-profile'; // API endpoint URL

    // Create the stream context with the above options
    $context = stream_context_create($options);
    
    // Send the HTTP POST request and capture the response
    $response = @file_get_contents($url, false, $context);

    // Check if the request failed
    if ($response === FALSE) {
        $error = error_get_last(); // Get the last error that occurred
       
        if (isset($http_response_header)) {
            echo "Response headers: ";
            echo "It looks like the email address you entered is already associated with another account. Please use a different email address.";
            echo "<br>";
        }
        exit; // Stop further execution if the request failed
    }

    // Decode the JSON response into a PHP array
    $result = json_decode($response, true);

    // Check if the API returned a success status
    if (isset($result['success']) && $result['success'] === true) {
       
        $_SESSION['success_data'] = [
            'success' => true,
            'message' => "Profile updated successfully"
        ];
        header("Location: dashboard.php"); // Redirect to the dashboard if profile creation was successful
        exit();
    } else {
        // Display user-friendly error message
        $error_message = $result['message'] ?? 'Profile creation failed due to an unknown error.';
        echo "Profile creation failed: $error_message<br>";
       
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <title>Create Profile</title>
    <link rel="stylesheet" href="assests/style.css"> 
</head>
<body>
    <div class="big_container">
        <h2>Create Your Profile</h2> 

        <form action="create_profile.php" method="post" class="create_p"> 
            <input type="text" name="name" id="name" placeholder="Full Name" required>
            <input type="email" name="email" id="email" placeholder="xyz@gmail.com" required> 
            <br>
            <input type="text" name="company" id="company" placeholder="Company Name" required> 
            <input type="text" name="state" id="state" placeholder="State" required> 
            <br>
            <input type="text" name="city" id="city" placeholder="City" required> 
            <input type="text" name="sponsorC" id="sponsor" placeholder="Sponsor Code" value="ABC123" required> 
            <br>
            <button type="submit">Create Profile</button> 
        </form>
    </div>
</body>
</html>

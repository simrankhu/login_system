<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $otp = $_POST['otp1'] . $_POST['otp2'] . $_POST['otp3'] . $_POST['otp4']; // combine the otp
// echo "Combined OTP: " . $otp; 


    // Retrieve the phone number from the session
    $country_c = $_SESSION['country_code'];
    $phone_num = $_SESSION['phone_number'];


    // Verify OTP through API
    $url = "http://185.193.19.48:9080/api/v1/verify-otp"; 
    $data = json_encode([
        "country_code" => $country_c,
        "mobile_number" => $phone_num,
        "otp" => $otp,
    

    ]);

    $options = [
        "http" => [
            "header"  => "Content-Type: application/json\r\n" .
                         "device-type: Mobile\r\n", 
            "method"  => "POST",
            "content" => $data,
        ],
        "ssl" => [
            "verify_peer" => false,
            "verify_peer_name" => false,
        ]
    ];

    $context = stream_context_create($options);
    $response = @file_get_contents($url, false, $context);
    
    if ($response === FALSE) {
        $error = error_get_last();
        die('Error verifying OTP: ' . $error['message']);
    }

    // Process the response
    $result = json_decode($response, true);
    echo $result;
    print_r($result);
    if (isset($result['success']) == true) {
        header("Location: create_profile.php"); // Redirect to the dashboard on success
        exit();
    } else {
        echo "OTP verification failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="assests/style.css">
</head>
<body>
    <div class="big_container">
        <h2>Verify OTP</h2>
        <p>Please enter the OTP sent to your phone number:</p>
        <form id="otpForm" action="verify_otp.php" method="POST">
            <div class="otp-inputs">
                <input type="text" maxlength="1" name="otp1" id="otp1" oninput="moveToNext(this, 'otp2')">
                <input type="text" maxlength="1" name="otp2" id="otp2" oninput="moveToNext(this, 'otp3')">
                <input type="text" maxlength="1" name="otp3" id="otp3" oninput="moveToNext(this, 'otp4')">
                <input type="text" maxlength="1" name="otp4" id="otp4">
            </div>
            <button type="submit">Verify</button>
        </form>
    </div>

    <script src="assests/scripts.js"></script>
</body>
</html>
<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $country_c = $_POST['country_c'];
    $phone_num = $_POST['phone_num'];

    // Save the phone number in the session
    $_SESSION['country_code'] = $country_c;
    $_SESSION['phone_number'] = $phone_num;

    // Send OTP  through API
    $url = "http://185.193.19.48:9080/api/v1/send-otp"; 

     // Prepare the data to be sent in json
    $data = json_encode([
        "country_code" => $country_c,
        "mobile_number" => $phone_num
    ]);

     // Set up the HTTP headers and options 
    $options = [
        "http" => [
            "header"  => "Content-Type: application/json\r\n", // Set the content type 
            "method"  => "POST",
            "content" => $data, // Attach the JSON data 
        ],
        "ssl" => [
            "verify_peer" => false, //Disable SSL verification(for no security)
            "verify_peer_name" => false,
        ]
    ];

    // Create a stream context with the specified options
    $context = stream_context_create($options);

    // Send the HTTP POST request and capture the response
    $response = file_get_contents('http://185.193.19.48:9080/api/v1/send-otp', false, $context);

    if ($response === FALSE) {
        die('Error sending OTP');  // for error checking if response is false
    }

    else{
    header("location:verify_otp.php");  //response is true so it rendered to verfiy page
        
    }
    exit();
}

<?php
// Get input data
$data = json_decode(file_get_contents('php://input'), true);
$mobileNumber = $data['mobile_number'];

// Log data for debugging
error_log("Received mobile number: " . $mobileNumber);

// Basic validation
if (!$mobileNumber) {
    echo json_encode(['success' => false, 'message' => 'Mobile number is required.']);
    exit();
}

// Mock response for testing (replace with actual API call)
$response = [
    'success' => true,
    'message' => 'OTP sent successfully to ' . $mobileNumber
];

// Uncomment the following for actual API integration
/*
$response = file_get_contents('http://example.com/api/v1/send-otp', false, stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => json_encode(['country_code' => '+91', 'mobile_number' => $mobileNumber])
    ]
]));
*/

if ($response === false) {
    error_log('Error: Failed to connect to the API.');
    echo json_encode(['success' => false, 'message' => 'Failed to send OTP. Please try again.']);
    exit();
}

header('Content-Type: application/json');
echo json_encode($response);
?>

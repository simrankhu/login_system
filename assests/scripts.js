// Show and hide different screens
function showScreen(screenId) {
    document.querySelectorAll('.screen').forEach(screen => screen.classList.add('hidden'));
    document.getElementById(screenId).classList.remove('hidden');
}

// Register User and send OTP
function registerUser() {
    const mobileNumber = document.getElementById('mobile-number').value;

    // Basic validation to check if the mobile number is entered
    if (!mobileNumber) {
        document.getElementById('register-error').textContent = 'Please enter your mobile number.';
        return;
    }

    // Clear previous error messages
    document.getElementById('register-error').textContent = '';

    // Sending POST request to registerUser.php
    fetch('registerUser.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ mobile_number: mobileNumber })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Response from server:', data); // Debugging log
        if (data.success) {
            showScreen('enter-otp-screen');
        } else {
            document.getElementById('register-error').textContent = data.message || 'Error registering user';
        }
    })
    .catch(error => {
        console.error('Error occurred:', error); // Error handling
        document.getElementById('register-error').textContent = 'Failed to send OTP. Please try again.';
    });
}

// Add event listener to the Send OTP button for better control
document.addEventListener('DOMContentLoaded', function () {
    const sendOtpButton = document.querySelector('#register-screen button');
    if (sendOtpButton) {
        sendOtpButton.addEventListener('click', registerUser);
    } else {
        console.error('Send OTP button not found.');
    }
});
function moveToNext(current, nextFieldID) {
    if (current.value.length >= current.maxLength) {
        document.getElementById(nextFieldID).focus();
    }
}

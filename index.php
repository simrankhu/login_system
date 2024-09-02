<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Mobile Number</title>
    <link rel="stylesheet" href="assests/style.css">
    <script src="../../../kit.fontawesome.com/42d5adcbca.html" crossorigin="anonymous"></script>
</head>

<body>
    <div class="big_container">
        <h2>Enter Phone Number</h2>
        <form action="send_otp.php" method="post">

            <select name="country_c" id="country_code">
                <option value="+91">+91</option>

            </select>

            <input type="number" name="phone_num" id="phone_number" required>
            <br>
            <button type="submit" name="submit">Send OTP</button>
        </form>
    </div>
</body>

</html>
<?php
session_start(); // Start the session to access session variables

// Ensure the email session is set before displaying the page
if (!isset($_SESSION["email"])) {
    header("Location: login.php"); // Redirect to login page if email is not set in session
    exit();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <style>
        body {
            margin: 0;
            background: #1a1a1a;
            height: 100vh;
            color: #fff;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            overflow: hidden;
        }

        .timer_container {
            width: 100%;
            display: flex;
        }

        #timer {
            font-size: 40px;
            font-weight: 600;
            color: #6e591a;
            margin: 20px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 70%;
        }

        .otp-field {
            display: flex;
        }

        .otp-field input {
            width: 24px;
            font-size: 32px;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            margin: 2px;
            border: 2px solid #2A2A2A;
            background: #21232d;
            font-weight: bold;
            color: #fff;
            outline: none;
            transition: all 0.1s;
        }

        .otp-field input:focus {
            border: 2px solid #6e591a;
            box-shadow: 0 0 2px 2px #4e46e593;
        }

        .disabled {
            opacity: 0.5;
        }

        .space {
            margin-right: 1rem !important;
        }

        .links {
            color: #6e591a;
            cursor: pointer;
        }
    </style>
    <title>OTP Verification</title>
</head>

<body>
    <div class="timer_container">
        <div id="timer">02:00</div>
    </div>

    <div class="container">
        <p>OTP sent to <span id="user-email">....12@gmail.com</span></p>
        <h1>Enter OTP</h1>
        <div class="otp-field">
            <input type="text" maxlength="1" id="otp1" required />
            <input type="text" maxlength="1" id="otp2" required />
            <input type="text" maxlength="1" id="otp3" required />
            <input type="text" maxlength="1" id="otp4" required />
            <input type="text" maxlength="1" id="otp5" required />
            <input type="text" maxlength="1" id="otp6" required />
        </div>

        <div style="margin-top: 20px;">
            <span>Didn't get an OTP?</span>
            <a class="links" id="resend_otp" href="javascript:void(0);">Resend?</a>
        </div>
    </div>

    <script>
        // Timer for OTP
        function startTimer(duration, display) {
            let timer = duration,
                minutes,
                seconds;
            let countdown = setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    clearInterval(countdown);
                    display.textContent = "00:00";
                    document.querySelectorAll(".otp-field input").forEach(input => input.disabled = true);
                    document.getElementById('resend_otp').style.display = 'inline-block';
                }
            }, 1000);
        }

        window.onload = function () {
            let twoMinutes = 120,
                display = document.querySelector('#timer');
            startTimer(twoMinutes, display);

            let userEmail = '<?php echo $_SESSION["email"]; ?>'; // Get email from session
            document.getElementById("user-email").textContent = userEmail; // Set the email in the span
        };

        // Handle OTP input field behavior
        const inputs = document.querySelectorAll(".otp-field input");
        inputs.forEach((input, index) => {
            input.dataset.index = index;
            input.addEventListener("keyup", handleOtp);
            input.addEventListener("paste", handleOnPasteOtp);
        });

        function handleOtp(e) {
            const input = e.target;
            let value = input.value;
            let isValidInput = value.match(/[0-9a-z]/gi);
            input.value = "";
            input.value = isValidInput ? value[0] : "";

            let fieldIndex = input.dataset.index;
            if (fieldIndex < inputs.length - 1 && isValidInput) {
                input.nextElementSibling.focus();
            }

            if (e.key === "Backspace" && fieldIndex > 0) {
                input.previousElementSibling.focus();
            }

            if (fieldIndex == inputs.length - 1 && isValidInput) {
                submitOtp();
            }
        }

        function handleOnPasteOtp(e) {
            const data = e.clipboardData.getData("text");
            const value = data.split("");
            if (value.length === inputs.length) {
                inputs.forEach((input, index) => (input.value = value[index]));
                submitOtp();
            }
        }

        function submitOtp() {
            let otp = '';
            inputs.forEach((input) => {
                otp += input.value;
                input.disabled = true;
            });

            let email = '<?php echo $_SESSION["email"]; ?>'; // Get email from session

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "verify_otp.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (xhr.status == 200) {
                    let response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        window.location.href = "dashboard.php"; // Redirect to login page
                    } else {
                        alert("Invalid or expired OTP. Please try again.");
                        inputs.forEach((input) => {
                            input.disabled = false;
                            input.classList.remove("disabled");
                        });
                    }
                }
            };

            xhr.send("otp=" + otp + "&email=" + email);
        }

        document.getElementById('resend_otp').addEventListener('click', function () {
    const email = '<?php echo $_SESSION["email"]; ?>'; // Get the email from the PHP session

    if (!email) {
        alert('Email not found. Please log in again.');
        return;
    }

    // Create a FormData object to send email as form data
    const formData = new FormData();
    formData.append('email', email);

    console.log('Sending request to resend OTP...');

    // Send the POST request with FormData
    fetch('resend_otp.php', {
        method: 'POST',
        body: formData // No need to set 'Content-Type' when using FormData
    })
    .then(response => {
        console.log('Received response:', response);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        // Attempt to parse the response as JSON
        return response.text().then(text => {
            try {
                return JSON.parse(text); // Try to parse the response as JSON
            } catch (error) {
                throw new Error('Failed to parse JSON: ' + text); // If parsing fails
            }
        });
    })
    .then(data => {
        console.log('Parsed JSON:', data);
        if (data.success) {
            alert(data.message); // Show success message
            location.reload();
        } else {
            alert(`Error: ${data.message}`); // Show error message
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An unexpected error occurred. Please try again.');
    });
});




    </script>
</body>

</html>

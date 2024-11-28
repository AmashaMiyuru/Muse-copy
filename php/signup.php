<html>
<head>
    <link rel="stylesheet" href="../css/signup.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body>
    <section>
        <br>
        <div class="signup-container">
            <div class="signup-box">
                <div class="logo">
                    <img src="../images/muse logo.png" alt="Muse Bookstore Logo">
                </div>
                <form action="../includes/signup.inc.php" method="post">
                    <input type="email" id="email" name="email" placeholder="Email Address" required>
                    <input type="text" id="name" name="name" placeholder="Name" required>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Re-enter Password" required>
                    <textarea id="address" name="address" placeholder="Enter Address" required></textarea>
                    <input type="tel" id="contactNumber" name="contactNumber" placeholder="Enter Contact Number" required pattern="[0-9]{10}" title="Please enter a valid 10-digit phone number">
                    <button type="submit" name="signupSubmit">Sign Up</button>
                </form>
            </div>
        </div>

        <script>
            // Function to show alert based on URL query parameters
            function showAlert() {
                const urlParams = new URLSearchParams(window.location.search);
                const error = urlParams.get('error');

                if (error) {
                    switch (error) {
                        case 'emptyinput':
                            alert('Error: Please fill in all fields.');
                            break;
                        case 'invalidemail':
                            alert('Error: Invalid email format.');
                            break;
                        case 'passwordmismatch':
                            alert('Error: Passwords do not match.');
                            break;
                        case 'none':
                            alert('Success: You have successfully signed up!');
                            break;
                        default:
                            alert('Unknown error occurred.');
                    }
                }
            }

            // Call showAlert when the page loads
            window.onload = showAlert;
        </script>
    </section>
</body>
</html>

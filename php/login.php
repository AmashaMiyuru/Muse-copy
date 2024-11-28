<html>
    <head>
    <link rel="stylesheet" href="../css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    </head>

    <body>
        <section>
        <br>
        <div class="login-container">
        <div class="login-box">
            <div class="logo">
                <img src="../images/muse logo.png" alt="Muse Bookstore Logo">
            </div>
            <form action="../includes/login.inc.php" method="post">
                <input type="text" name="name" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                   <div class="options">
                      <a href="#">Forgot Password?</a>
                    </div>
                <button type="submit" name="submit">Login</button>
            </form>

            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
    </div>
        </section>
        
   

    </body>
</html>

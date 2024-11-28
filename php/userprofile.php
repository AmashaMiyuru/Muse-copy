<?php
session_start();

// Handle errors from the previous submission
if (isset($_GET['error'])) {
    $error = $_GET['error'];
} else {
    $error = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="../css/userprofile.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script>
        // Enable the fields for editing
        function enableEdit() {
            document.getElementById("username").disabled = false;
            document.getElementById("email").disabled = false;
            document.getElementById("address").disabled = false;
            document.getElementById("contactNumber").disabled = false;
            document.getElementById("saveBtn").style.display = "block";
        }
    </script>
</head>
<body>
     <!-- Sidebar -->
     <div class="sidebar">
    <li class="logo-container">
        <img src="../images/muse logo.png" alt="Muse Bookstore Logo">
    </li>
    <nav>
        <ul>
            <li class="active"><a href="user.php"><i class="fas fa-tachometer-alt"></i> Welcome to dashboard</a></li>
            <li><a href="userprofile.php"><i class="fas fa-user"></i> Profile</a></li>
            <li><a href="books.php"><i class="fas fa-book"></i> Books</a></li>
            <li><a href="communities.php"><i class="fas fa-users"></i> Communities</a></li>
            <li><a href="blogs.php"><i class="fas fa-blog"></i> Blogs</a></li>
            <li><a href="writing-groups.php"><i class="fas fa-pen"></i> Writing Groups</a></li>
            <li><a href="#"><i class="fas fa-envelope"></i> Messages</a></li>
        </ul>
        <ul>
            <li><a href="my-books.php"><i class="fas fa-bookmark"></i> My Books</a></li>
            <li><a href="calendar.php"><i class="fas fa-calendar-alt"></i> Calendar</a></li>
            <li><a href="wishlist.php"><i class="fas fa-heart"></i> Wish-list</a></li>
            <li><a href="wishlist.php"><i class="fas fa-bell"></i> Notifications</a></li>
            <li><a href="#"><i class="fas fa-shopping-cart"></i> Cart</a></li>
            <li><a href="../includes/logout.inc.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </nav>
</div>


    <!-- Main content -->
    <div class="main-content">
        <div class="profile-container">
            <h1>User Profile</h1>

            <!-- Display error message -->
            <?php if ($error == 'invalidemail'): ?>
                <p class="error">Invalid email format.</p>
            <?php elseif ($error == 'usernameexists'): ?>
                <p class="error">The username already exists. Please choose another one.</p>
            <?php elseif ($error == 'emptyfields'): ?>
                <p class="error">Please fill in all fields.</p>
            <?php elseif ($error == 'updatefailed'): ?>
                <p class="error">Profile update failed. Please try again.</p>
            <?php endif; ?>

            <!-- Profile form -->
            <form method="POST" action="update_profile.php" class="profile-form">
                <label>Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" disabled>

                <label>Email address:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['useremail']); ?>" disabled>

                <label>Address:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($_SESSION['useraddress']); ?>" disabled>

                <label>Contact Number:</label>
                <input type="text" id="contactNumber" name="contactNumber" value="<?php echo htmlspecialchars($_SESSION['userphone']); ?>" disabled>

                <!-- Edit button -->
                <button type="button" class="edit-btn" onclick="enableEdit()">Edit Profile</button>
                
                <!-- Save button (only visible when editing) -->
                <button type="submit" id="saveBtn" style="display: none;">Save Changes</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
session_start();
require_once '../classes/community.classes.php';

// Initialize error and success messages
$error = '';
$success = '';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $communityName = trim($_POST['community_name'] ?? '');
    $communityType = trim($_POST['community_type'] ?? '');
    $communityDescription = trim($_POST['community_description'] ?? '');
    $imageFile = $_FILES['community_image'] ?? null;

    // Validate required fields
    if (empty($communityName) || empty($communityType) || empty($communityDescription) || empty($imageFile['name'])) {
        $error = 'Please fill in all fields and upload an image.';
    } else {
        // File upload directory
        $targetDir = '../images/community/';
        $imageName = preg_replace('/[^a-zA-Z0-9\-_\.]/', '', basename($imageFile['name'])); // Sanitize file name
        $targetFile = $targetDir . $imageName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Validate file type
        if (!in_array($imageFileType, $allowedExtensions)) {
            $error = 'Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.';
        } elseif (!move_uploaded_file($imageFile['tmp_name'], $targetFile)) {
            $error = 'Error uploading the image. Please try again.';
        } else {
            // Save community data to the database
            try {
                $community = new Community();
                $community->addCommunity($communityName, $communityType, $communityDescription, $imageName); // Pass only the file name
                $success = 'Community created successfully!';
                if ($success) {
                    header("Location: communities.php");
                    exit();
                } else {
                    header("Location: createCommunity.php");
                    exit();
                }
            } catch (Exception $e) {
                $error = 'Error saving community to the database: ' . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Community</title>
    <link rel="stylesheet" href="../css/create_community.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Sidebar (if needed) -->
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

    <!-- Main Content -->
    <div class="main-content">
        <div class="profile-container">
            <h1>Create a New Community</h1>

            <!-- Display error message if any -->
            <?php if (!empty($error)): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <!-- Display success message if any -->
            <?php if (!empty($success)): ?>
                <p class="success"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>

            <!-- Community Creation Form -->
            <form method="POST" action="createCommunity.php" enctype="multipart/form-data" class="community-form">
                <label for="community_name">Community Name:</label>
                <input type="text" id="community_name" name="community_name" placeholder="Enter community name" required>

                <label for="community_type">Community Type:</label>
                <input type="text" id="community_type" name="community_type" placeholder="Enter community type" required>

                <label for="community_description">Description:</label>
                <textarea id="community_description" name="community_description" placeholder="Enter community description" required></textarea>

                <label for="community_image">Upload Community Image:</label>
                <input type="file" id="community_image" name="community_image" accept=".jpg, .jpeg, .png, .gif" required>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn">Create Community</button>
            </form>
        </div>
    </div>
</body>
</html>


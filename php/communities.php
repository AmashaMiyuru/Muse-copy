<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

$loggedUserId = $_SESSION['userid'];
$loggedUserName = $_SESSION['username'];
require_once '../classes/community.classes.php';
if (isset($_SESSION['userid'])) {
    $loggedUserId = $_SESSION['userid'];

}

// Check for any errors from a previous form submission
$error = isset($_GET['error']) ? $_GET['error'] : '';

// Initialize Community object and fetch all communities
$communityObj = new Community();
$communities = $communityObj->getAllCommunities();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Communities List</title>
    <link rel="stylesheet" href="../css/communities.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        <h1><center>Communities</center></h1>
        <p>Logged User ID: <?php echo htmlspecialchars($loggedUserId); ?></p>

        <!-- Display error message if any -->
        <?php if ($error == 'nocommunityid'): ?>
            <p class="error">No community ID provided. Please select a community to view details.</p>
        <?php endif; ?>

        <a href="createCommunity.php" class="create-community-btn">Create Community</a>

        <!-- Communities Blocks -->
        <div class="communities-grid">
            <?php if (!empty($communities)): ?>
                <?php foreach ($communities as $community): ?>
                    <div class="community-block">
                    <img src="../images/community/<?php echo htmlspecialchars($community['community_image']); ?>" alt="Community Image">

    <h2><?php echo htmlspecialchars($community['community_name']); ?></h2>
    <p class="community-type"><?php echo htmlspecialchars($community['community_type']); ?></p>
    <a href="community_details.php?community_id=<?php echo $community['community_id']; ?>" class="view-details-btn">View Details</a>
</div>


                <?php endforeach; ?>
            <?php else: ?>
                <p>No communities found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>

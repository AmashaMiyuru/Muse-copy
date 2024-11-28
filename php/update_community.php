<?php
session_start();
require_once '../classes/community.classes.php';

$communityObj = new Community();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $community_id = $_POST['community_id'];
    $community_name = htmlspecialchars($_POST['community_name']);
    $community_type = htmlspecialchars($_POST['community_type']);
    $community_description = htmlspecialchars($_POST['community_description']);

    // Validate inputs
    if (empty($community_name) || empty($community_type) || empty($community_description)) {
        header("Location: update_community.php?community_id=$community_id&error=emptyfields");
        exit();
    }

    // Update the community
    if ($communityObj->updateCommunity($community_id, $community_name, $community_type, $community_description)) {
        header("Location: community_details.php?community_id=$community_id&success=updated");
        exit();
    } else {
        header("Location: update_community.php?community_id=$community_id&error=updatefailed");
        exit();
    }
}

// If not submitted, display the form
if (!isset($_GET['community_id'])) {
    header("Location: communities.php?error=nocommunityid");
    exit();
}

$community_id = $_GET['community_id'];
$community = $communityObj->getCommunityById($community_id);

if (!$community) {
    header("Location: communities.php?error=communitynotfound");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Community</title>
    <link rel="stylesheet" href="../css/update_community.css">
</head>
<body>
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
    
    <div class="container">
        <h1>Edit Community</h1>
        <?php if (isset($_GET['error']) && $_GET['error'] === 'emptyfields'): ?>
            <p style="color: red;">Please fill in all the fields.</p>
        <?php elseif (isset($_GET['error']) && $_GET['error'] === 'updatefailed'): ?>
            <p style="color: red;">Failed to update the community. Please try again.</p>
        <?php endif; ?>

        <form action="update_community.php" method="POST">
            <input type="hidden" name="community_id" value="<?php echo htmlspecialchars($community_id); ?>">
            
            <label for="community_name">Community Name:</label>
            <input type="text" name="community_name" id="community_name" value="<?php echo htmlspecialchars($community['community_name']); ?>" required>
            
            <label for="community_type">Community Type:</label>
            <input type="text" name="community_type" id="community_type" value="<?php echo htmlspecialchars($community['community_type']); ?>" required>
            
            <label for="community_description">Description:</label>
            <textarea name="community_description" id="community_description" required><?php echo htmlspecialchars($community['community_description']); ?></textarea>
            
            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>

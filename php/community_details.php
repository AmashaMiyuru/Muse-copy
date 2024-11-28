<?php
session_start();
require_once '../classes/community.classes.php';

// Check if community_id is provided in the URL
if (isset($_GET['community_id'])) {
    $communityId = $_GET['community_id'];
} else {
    header("Location: communities.php?error=nocommunityid"); // Redirect if no community_id is provided
    exit();
}

// Initialize the Community object and fetch community details
$communityObj = new Community();
$community = $communityObj->getCommunityById($communityId);

// If community doesn't exist, redirect to communities page
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
    <title><?php echo htmlspecialchars($community['community_name']); ?> - Community Details</title>
    <link rel="stylesheet" href="../css/community_details.css">
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
   
            <h1>Community Details</h1>

            <!-- Community Details -->
            <div class="community-details">
                <div class="community-image">
                    <img src="../images/community/<?php echo htmlspecialchars($community['community_image']); ?>" alt="Community Image">
                    <div class="community-buttons">
                   <a href="addmembers.php?community_id=<?php echo $community['community_id']; ?>" class="add-member-btn">Add Members</a>
                    <a href="manage_posts.php?community_id=<?php echo $community['community_id']; ?>" class="manage-posts-btn">Manage Posts</a> 
                   <a href="event.php?community_id=<?php echo $community['community_id']; ?>" class="add-member-btn">Events</a>
                    <a href="writing_groups.php?community_id=<?php echo $community['community_id']; ?>" class="edit-community-btn">Writing Groups</a>
                    <a href="update_community.php?community_id=<?php echo $community['community_id']; ?>" class="edit-community-btn">Edit Community</a>
                    <a href="delete_community.php?community_id=<?php echo $community['community_id']; ?>" class="delete-community-btn" onclick="return confirm('Are you sure you want to delete this community?');">Delete Community</a>
                    </div>
                </div>
                <div class="community-info">
                    <h2><?php echo htmlspecialchars($community['community_name']); ?></h2>
                    <p class="community-type"><strong>Type:</strong> <?php echo htmlspecialchars($community['community_type']); ?></p>
                    <p class="community-description"><?php echo nl2br(htmlspecialchars($community['community_description'])); ?></p><br>
                   <br><br>
                    <section class="rules-section">
                    <h3><i>Rules and Regulations</i></h3>
                    <ul>
                        <li>Be respectful to all community members.</li>
                        <li>Keep discussions relevant to the community's theme.</li>
                        <li>No spamming, trolling, or offensive language.</li>
                        <li>Ensure all shared content complies with copyright laws.</li>
                        <li>Report inappropriate behavior to the community admin.</li>
                        <li>Follow the specific guidelines set by the community admin.</li>
                    </ul>
                </section>
                 <br>
                   </div>
            
        
    
</body>
</html>

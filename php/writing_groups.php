<?php
session_start();
require_once '../classes/writingGroup.classes.php'; // Include a class to handle writing groups logic

// Check if community_id is provided in the URL
if (isset($_GET['community_id'])) {
    $communityId = $_GET['community_id'];
} else {
    header("Location: communities.php?error=nocommunityid"); // Redirect if no community_id is provided
    exit();
}

// Initialize the WritingGroups object and fetch writing groups for the community
$writingGroupsObj = new WritingGroups();
$writingGroups = $writingGroupsObj->getWritingGroupsByCommunityId($communityId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Writing Groups</title>
    <link rel="stylesheet" href="../css/writing_group.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <header class="hero">
        <div class="hero-content">
            <h1 class="hero-title">JOIN A <span class="highlight">WRITING GROUP</span></h1>
            <p class="hero-subtitle">BECOME A BETTER WRITER</p>
            <p class="hero-description">
                Meet new friends for support and feedback on your journey to getting published, 
                or find a writing course and improve your skills.
            </p>
            <button class="hero-button" id="join-now-btn">Join a Writing Group Now</button>
        </div>
    </header>

            <!-- Sidebar -->
            <div class="sidebar">
        <li class="logo-container">
            <img src="../images/muse logo.png" alt="Muse Bookstore Logo">
        </li>
        <nav>
            <ul>
                <li class="active"><a href="user.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="userprofile.php"><i class="fas fa-user"></i> Profile</a></li>
                <li><a href="books.php"><i class="fas fa-book"></i> Books</a></li>
                <li><a href="communities.php"><i class="fas fa-users"></i> Communities</a></li>
                <li><a href="blogs.php"><i class="fas fa-blog"></i> Blogs</a></li>
                <li><a href="writing-groups.php"><i class="fas fa-pen"></i> Writing Groups</a></li>
                <li><a href="#"><i class="fas fa-envelope"></i> Messages</a></li>
            </ul>
        </nav>
    </div>

    <div class="container">
        <section class="groups-section">
            <h2 class="section-title">Available Writing Groups</h2>
            <?php if (!empty($writingGroups)): ?>
                <ul class="group-cards">
                    <?php foreach ($writingGroups as $group): ?>
                        <li class="group-card">
                            <a href="writing_group_posts.php?group_id=<?php echo $group['id']; ?>" class="card-link">
                                <div class="img">
                                    <img src="../images/writing_group2.jpg" alt="group image">
                                </div> 
                                <div class="card-header">
                                    <h3 class="group-name"><?php echo htmlspecialchars($group['name']); ?></h3>
                                </div>
                                <div class="card-body">
                                    <p class="group-description">Connect with writers and share ideas.</p>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="no-groups-message">No writing groups found. Be the first to create one!</p>
            <?php endif; ?>
        </section>
    </div>

    <script src="../js/writing_groups.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const sidebar = document.querySelector(".sidebar");
        const headerHeight = document.querySelector(".hero").offsetHeight;

        window.addEventListener("scroll", function () {
            if (window.scrollY >= headerHeight) {
                sidebar.classList.add("fixed");
                document.body.classList.add("sidebar-active");
            } else {
                sidebar.classList.remove("fixed");
                document.body.classList.remove("sidebar-active");
            }
        });
    });
</script>


</body>
</html>

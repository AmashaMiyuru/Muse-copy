<?php
require_once '../classes/post.classes.php';
session_start();

// Retrieve community_id from the URL
$communityId = isset($_GET['community_id']) ? intval($_GET['community_id']) : null;

// Initialize variables
$error = '';
$posts = [];

if ($communityId) {
    try {
        $postObj = new Post();
        $posts = $postObj->getPostsByCommunityId($communityId);
    } catch (Exception $e) {
        $error = "Failed to load posts: " . $e->getMessage();
    }
} else {
    $error = "Community ID is required.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Posts</title>
    <link rel="stylesheet" href="../css/post.css">
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
        <h1>Manage Posts</h1>

        <!-- Display Error or Success Messages -->
        <?php if (!empty($error)) { ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php } ?>
        <?php if (isset($_GET['success'])) { ?>
            <div class="success"><?php echo htmlspecialchars($_GET['success']); ?></div>
        <?php } ?>

        <!-- Button to open popup -->
        <button id="openPopup" class="create-post-btn">Create New Post</button>

        <!-- Popup for creating a post -->
        <div class="popup-overlay" id="popupOverlay"></div>
        <div class="popup" id="createPostPopup">
            <span class="close-btn" id="closePopup">&times;</span>
            <h2>Create New Post</h2>
            <form method="POST" action="create_post.php" enctype="multipart/form-data">
                <input type="hidden" name="community_id" value="<?php echo $communityId; ?>">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
                
                <label for="content">Content:</label>
                <textarea id="content" name="content" rows="5" required></textarea>

                <label for="image">Upload Image:</label>
                <input type="file" id="image" name="image" accept="image/*">

                <button type="submit" name="create_post">Create Post</button>
            </form>
        </div>

       <!-- Posts Feed -->
       <div class="main-content">
      <div class="posts-feed">
       <h2>Community Posts</h2>
        <?php if (!empty($posts)) { ?>
        <?php foreach ($posts as $post) { ?>
            <div class="post-card">
                <div class="post-header">
                    <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                    <span class="post-date">
                        <?php echo date("F j, Y, g:i a", strtotime($post['created_at'])); ?>
                    </span>
                </div>
                <div class="post-body">
                    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                    <?php if (!empty($post['image'])) { ?>
                        <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image">
                    <?php } ?>
                </div>
                <div class="post-actions">
                    <a href="edit_post.php?post_id=<?php echo $post['post_id']; ?>" class="edit-btn">Edit</a>
                </div>
                <div class="post-actions">
                    <a href="delete_post.php?post_id=<?php echo $post['post_id']; ?>" class="delete-btn">Delete</a>
                </div>
            </div>
           <?php } ?>
         <?php } else { ?>
        <p>No posts available in this community.</p>
         <?php } ?>
      </div>
      </div>

    </div>

    <script>
        // JavaScript for popup functionality
        const openPopup = document.getElementById('openPopup');
        const closePopup = document.getElementById('closePopup');
        const popup = document.getElementById('createPostPopup');
        const overlay = document.getElementById('popupOverlay');

        openPopup.addEventListener('click', () => {
            popup.classList.add('active');
            overlay.classList.add('active');
        });

        closePopup.addEventListener('click', () => {
            popup.classList.remove('active');
            overlay.classList.remove('active');
        });

        overlay.addEventListener('click', () => {
            popup.classList.remove('active');
            overlay.classList.remove('active');
        });
    </script>
</body>
</html>

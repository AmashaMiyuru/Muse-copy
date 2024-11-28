<?php
require_once '../classes/post.classes.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['users_id'])) {
    header('Location: login.php');
    exit();
}

$error = '';
$success = '';
$post = null;

// Retrieve the post ID from the URL
$postId = isset($_GET['post_id']) ? intval($_GET['post_id']) : null;

if ($postId) {
    try {
        // Instantiate the Post object
        $postObj = new Post();
        // Fetch the post data by ID
        $post = $postObj->getPostById($postId);
        
        // Check if the post exists
        if (!$post) {
            $error = 'Post not found.';
        }
    } catch (Exception $e) {
        $error = 'Failed to load the post: ' . $e->getMessage();
    }
} else {
    $error = 'Post ID is required.';
}

// Handle the form submission for updating the post
if (isset($_POST['update_post'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image']['name'];

    // Validate input
    if (empty($title) || empty($content)) {
        $error = 'Title and content are required.';
    } else {
        try {
            // Update the post in the database
            $postObj->updatePost($postId, $title, $content, $image);

            // If an image is uploaded, move it to the appropriate directory
            if ($image) {
                $targetDir = '../uploads/';
                $targetFile = $targetDir . basename($image);
                move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
            }

            $success = 'Post updated successfully.';
        } catch (Exception $e) {
            $error = 'Failed to update the post: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="../css/post.css">
</head>
<body>

<!-- Sidebar omitted for brevity -->

<div class="container">
    <h1>Edit Post</h1>

    <!-- Display Error or Success Messages -->
    <?php if (!empty($error)) { ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php } ?>
    <?php if (!empty($success)) { ?>
        <div class="success"><?php echo htmlspecialchars($success); ?></div>
    <?php } ?>

    <!-- Edit Post Form -->
    <form method="POST" action="edit_post.php?post_id=<?php echo $post['post_id']; ?>" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>

        <label for="content">Content:</label>
        <textarea id="content" name="content" rows="5" required><?php echo htmlspecialchars($post['content']); ?></textarea>

        <label for="image">Upload New Image (optional):</label>
        <input type="file" id="image" name="image" accept="image/*">

        <button type="submit" name="update_post">Update Post</button>
    </form>
</div>

</body>
</html>

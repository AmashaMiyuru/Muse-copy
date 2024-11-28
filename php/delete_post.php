<?php
require_once '../classes/post.classes.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Retrieve the post ID from the URL
$postId = isset($_GET['post_id']) ? intval($_GET['post_id']) : null;

if ($postId) {
    try {
        // Instantiate the Post object
        $postObj = new Post();
        // Delete the post from the database
        $postObj->deletePost($postId);

        // Redirect with a success message
        header('Location: manage_posts.php?success=Post deleted successfully.');
        exit();
    } catch (Exception $e) {
        // Redirect with an error message if something goes wrong
        header('Location: manage_posts.php?error=Failed to delete post: ' . $e->getMessage());
        exit();
    }
} else {
    header('Location: manage_posts.php?error=Post ID is required.');
    exit();
}

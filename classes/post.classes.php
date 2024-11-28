<?php
require_once 'dbh.classes.php';

class Post extends Dbh {
    // Create a new post
    public function createPost($communityId, $userId, $title, $content, $image) {
        $query = "INSERT INTO posts1 (community_id, user_id, title, content, image) VALUES (:community_id, :user_id, :title, :content, :image)";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindValue(':community_id', $communityId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':content', $content, PDO::PARAM_STR);
        $stmt->bindValue(':image', $image, PDO::PARAM_STR);
        $stmt->execute();
    }
    
    // Get all posts for a specific community
    public function getPostsByCommunityId($communityId) {
        $stmt = $this->connect()->prepare("SELECT * FROM posts1 WHERE community_id = :community_id ORDER BY created_at DESC");
        $stmt->bindValue(':community_id', $communityId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a post by its ID
    public function getPostById($postId) {
        $stmt = $this->connect()->prepare("SELECT * FROM posts1 WHERE post_id = :post_id");
        $stmt->bindValue(':post_id', $postId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to update a post
    public function updatePost($postId, $title, $content, $image) {
        $sql = "UPDATE posts1 SET title = :title, content = :content, image = :image WHERE post_id = :post_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Delete a specific post
    public function deletePost($postId) {
        $stmt = $this->connect()->prepare("DELETE FROM posts1 WHERE post_id = :post_id");
        $stmt->bindValue(':post_id', $postId, PDO::PARAM_INT);
        $stmt->execute();
    }
}
?>

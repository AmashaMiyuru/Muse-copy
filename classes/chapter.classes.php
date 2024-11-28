<?php
require_once 'dbh.classes.php';
class Chapter extends Dbh {
    public function getPostsByGroupId($groupId) {
        $sql = "SELECT * FROM chapters WHERE group_id = ? ORDER BY created_at ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$groupId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createPost($groupId, $title, $content, $author) {
        $sql = "INSERT INTO chapters (group_id, title, content, author) VALUES (?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$groupId, $title, $content, $author]);
    }
}
?>
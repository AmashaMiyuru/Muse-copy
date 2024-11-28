<?php
require_once 'dbh.classes.php';

class WritingGroups extends Dbh {

    // Retrieve all writing groups for a specific community
    public function getWritingGroupsByCommunityId($communityId) {
        $query = "SELECT * FROM writing_groups WHERE community_id = ?"; // Correct query
        $stmt = $this->connect()->prepare($query);
        $stmt->execute([$communityId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows as an array
    }

    // Create a new writing group
    public function createWritingGroup($communityId, $groupName) {
        $sql = "INSERT INTO writing_groups (community_id, name) VALUES (?, ?)";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$communityId, $groupName]);
    }

    public function getWritingGroupById($groupId) {
        $query = "SELECT * FROM writing_groups WHERE id = ?";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute([$groupId]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single group
    }
    
}
?>

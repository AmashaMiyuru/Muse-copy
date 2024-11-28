<?php
require_once 'dbh.classes.php';
class Community extends Dbh {

    // Fetch all communities
    public function getAllCommunities() {
        try {
            $stmt = $this->connect()->prepare("SELECT * FROM communities");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: []; // Return empty array if no results
        } catch (PDOException $e) {
            error_log("Database query error: " . $e->getMessage());
            return []; // Return empty array on error
        }
    }

    public function addCommunity($name, $type, $description, $imageName) {
        try {
            $stmt = $this->connect()->prepare("INSERT INTO communities (community_name, community_type, community_description, community_image) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $type, $description, $imageName]);
        } catch (PDOException $e) {
            error_log("Database insert error: " . $e->getMessage());
        }
    }
    

    public function getCommunityById($communityId) {
        $sql = "SELECT * FROM communities WHERE community_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$communityId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateCommunity($community_id, $name, $type, $description) {
        $stmt = $this->connect()->prepare("UPDATE communities SET community_name = ?, community_type = ?, community_description = ? WHERE community_id = ?");
        return $stmt->execute([$name, $type, $description, $community_id]);
    }

    // Check if community name exists in the database
    public function communityNameExists($name, $communityId) {
        try {
            // Prepare the SQL query to check if a community name exists, excluding the current community
            $stmt = $this->connect()->prepare('SELECT * FROM communities WHERE community_name = ? AND community_id != ?');
            $stmt->execute([$name, $communityId]);
            
            return $stmt->rowCount() > 0; // Return true if a matching community name is found, false otherwise
        } catch (PDOException $e) {
            error_log("Database query error: " . $e->getMessage());
            return false; // Return false on error
        }
    }

    public function requestCommunityDeletion($communityId, $userId, $reason) {
        try {
            $stmt = $this->connect()->prepare("INSERT INTO deletion_requests (community_id, requested_by, reason, status, request_date) VALUES (?, ?, ?, 'Pending', NOW())");
            $stmt->execute([$communityId, $userId, $reason]);
            return true; // Request successfully created
        } catch (PDOException $e) {
            error_log("Database insert error: " . $e->getMessage());
            return false;
        }
    }

    public function addMemberToCommunity($communityId, $memberName, $memberEmail)
{
    $sql = "INSERT INTO community_members (community_id, member_name, member_email) VALUES (?, ?, ?)";
    $stmt = $this->connect()->prepare($sql);
    
    try {
        $stmt->execute([$communityId, $memberName, $memberEmail]);
        return true;
    } catch (PDOException $e) {
        error_log("Failed to add member: " . $e->getMessage());
        return false;
    }
}

public function getCommunityMembers($communityId)
{
    $sql = "
        SELECT users.users_id, users.users_name, users.users_email 
        FROM community_members 
        JOIN users ON community_members.user_id = users.users_id 
        WHERE community_members.community_id = ?
    ";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$communityId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}
?>

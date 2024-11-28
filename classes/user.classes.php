<?php
class User extends Dbh {

    // Fetch user profile based on user ID
    public function getUserProfile($userId) {
        $stmt = $this->connect()->prepare('SELECT * FROM users WHERE users_id = ?');
        
        if (!$stmt->execute(array($userId))) {
            $stmt = null;
            header("location: ../php/userprofile.php?error=stmtfailed");
            exit();
        }

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            header("location: ../php/userprofile.php?error=usernotfound");
            exit();
        }

        // Fetch and return user profile details
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    // Update user profile
    public function updateUserProfile($userId, $username, $email, $address, $contactNumber) {
        $stmt = $this->connect()->prepare('UPDATE users SET users_name = ?, users_email = ?, users_address = ?, users_contactNumber = ? WHERE users_id = ?');

        if (!$stmt->execute(array($username, $email, $address, $contactNumber, $userId))) {
            $stmt = null;
            header("location: ../php/userprofile.php?error=updatefailed");
            exit();
        }

        return true;
    }
     // Check if username exists in the database
     public function usernameExists($username, $userId) {
        // Prepare the SQL query to check if a username exists, excluding the current user
        $stmt = $this->connect()->prepare('SELECT * FROM users WHERE users_name = ? AND users_id != ?;');
        
        if (!$stmt->execute(array($username, $userId))) {
            $stmt = null;
            return false; // If the query fails, return false
        }

        if ($stmt->rowCount() > 0) {
            return true; // Username already exists in the database (excluding current user)
        }

        return false; // Username does not exist
    }

    
    // Fetch user profile based on user ID
    public function getAllUsers() {
        $stmt = $this->connect()->prepare('SELECT * FROM users');
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
}
?>

<?php
require_once 'dbh.classes.php';

class Event extends Dbh {

    public function getEventsByCommunityId($communityId) {
        $query = "SELECT * FROM events WHERE community_id = ?";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute([$communityId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function joinEvent($eventId, $userId) {
        $query = "INSERT INTO event_participants (event_id, user_id) VALUES (?, ?)";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute([$eventId, $userId]);
    }

    public function getJoinedPeople($eventId) {
        $query = "SELECT users.users_name FROM event_participants
                  JOIN users ON event_participants.user_id = users.users_id
                  WHERE event_participants.event_id = ?";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute([$eventId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createEvent($communityId, $title, $reason, $place, $date, $time) {
        $query = "INSERT INTO events (community_id, title, reason, place, date, time) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute([$communityId, $title, $reason, $place, $date, $time]);
    }
}
?>

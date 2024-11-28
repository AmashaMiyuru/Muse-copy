<?php
session_start();
require_once '../classes/event.classes.php';
require_once '../classes/community.classes.php';

// Check if community_id is provided in the URL
if (isset($_GET['community_id'])) {
    $communityId = $_GET['community_id'];
} else {
    header("Location: communities.php?error=nocommunityid");
    exit();
}

if (!isset($_SESSION['userid'])) {
    header("Location: login.php?error=notloggedin");
    exit();
}

$userId = $_SESSION['userid'];

// Initialize the Events and Community objects
$eventObj = new Event();
$communityObj = new Community();
$community = $communityObj->getCommunityById($communityId);

// If community doesn't exist, redirect to communities page
if (!$community) {
    header("Location: communities.php?error=communitynotfound");
    exit();
}


// Handle joining the event
if (isset($_POST['join_event'])) {
    $eventId = $_POST['event_id'];
    $userId = $_SESSION['userid']; // Assuming user_id is stored in the session
    $eventObj->joinEvent($eventId, $userId);
}

// Fetch events for the community
$events = $eventObj->getEventsByCommunityId($communityId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($community['community_name']); ?> - Events</title>
    <link rel="stylesheet" href="../css/event.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <h1><?php echo htmlspecialchars($community['community_name']); ?> - Events</h1>

    <!-- Create Event Button -->
    <div class="create-event-container">
        <a href="create_event.php?community_id=<?php echo $communityId; ?>" class="create-event-btn">Create Event</a>
    </div>

    <!-- Events List -->
    <div class="events-container">
        <?php if (!empty($events)): ?>
            <?php foreach ($events as $event): ?>
                <div class="event">
                    <h2><?php echo htmlspecialchars($event['title']); ?></h2>
                    <p><strong>Reason:</strong> <?php echo htmlspecialchars($event['reason']); ?></p>
                    <p><strong>Place:</strong> <?php echo htmlspecialchars($event['place']); ?></p>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($event['date']); ?></p>
                    <p><strong>Time:</strong> <?php echo htmlspecialchars($event['time']); ?></p>
                    <!-- Join Event Button -->
                    <form method="POST">
                        <input type="hidden" name="event_id" value="<?php echo $event['event_id']; ?>">
                        <button type="submit" name="join_event" class="join-btn">Join Event</button>
                    </form>
                    <!-- List of Joined People -->
                    <div class="joined-people">
                        <h3>People Who Joined:</h3>
                        <ul>
                            <?php
                            $joinedPeople = $eventObj->getJoinedPeople($event['event_id']);
                            if (!empty($joinedPeople)) {
                                foreach ($joinedPeople as $person) {
                                    echo '<li>' . htmlspecialchars($person['users_name']) . '</li>';
                                }
                            } else {
                                echo '<li>No one has joined yet.</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No events found for this community.</p>
        <?php endif; ?>
    </div>
</body>
</html>

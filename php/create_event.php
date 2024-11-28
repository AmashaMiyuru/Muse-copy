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

// Initialize the Community object to fetch community details
$communityObj = new Community();
$community = $communityObj->getCommunityById($communityId);

// If community doesn't exist, redirect to communities page
if (!$community) {
    header("Location: communities.php?error=communitynotfound");
    exit();
}

// Handle form submission to create an event
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $reason = $_POST['reason'];
    $place = $_POST['place'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Validate inputs
    if (empty($title) || empty($reason) || empty($place) || empty($date) || empty($time)) {
        $error = "All fields are required.";
    } else {
        // Save the event
        $eventObj = new Event();
        $eventObj->createEvent($communityId, $title, $reason, $place, $date, $time);
        header("Location: events.php?community_id=$communityId&success=eventcreated");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event - <?php echo htmlspecialchars($community['community_name']); ?></title>
    <link rel="stylesheet" href="../css/events.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <h1>Create Event for <?php echo htmlspecialchars($community['community_name']); ?></h1>

    <?php if (!empty($error)): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" class="create-event-form">
        <div class="form-group">
            <label for="title">Event Title:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="reason">Reason for Event:</label>
            <textarea id="reason" name="reason" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="place">Place:</label>
            <input type="text" id="place" name="place" required>
        </div>
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required>
        </div>
        <button type="submit" class="create-event-btn">Create Event</button>
    </form>
</body>
</html>

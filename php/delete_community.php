<?php
session_start();
require_once '../classes/community.classes.php';

if (!isset($_GET['community_id'])) {
    header("Location: communities.php?error=nocommunityid");
    exit();
}

$communityId = $_GET['community_id'];
$communityObj = new Community();
$community = $communityObj->getCommunityById($communityId);

if (!$community) {
    header("Location: communities.php?error=communitynotfound");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reason = htmlspecialchars($_POST['reason']);
    $userId = $_SESSION['userid'];

    // Request deletion by inserting into the deletion_requests table
    $requestCreated = $communityObj->requestCommunityDeletion($communityId, $userId, $reason);

    if ($requestCreated) {
        header("Location: delete_community.php?community_id=$communityId&success=deletionrequested");
        exit();
    } else {
        header("Location: delete_community.php?community_id=$communityId&error=deletionrequestfailed");
        exit();
    }
    
}

// Fetch the username of the person making the request
require_once '../classes/user.classes.php';
$userObj = new User();
$user = $userObj->getUserById($_SESSION['userid']);
$username = $user['users_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Deletion - <?php echo htmlspecialchars($community['community_name']); ?></title>
    <link rel="stylesheet" href="../css/delete_community.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        // Check for success message in URL
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success') && urlParams.get('success') === 'deletionrequested') {
                // Show success message in a pop-up
                alert("Your request for community deletion has been successfully submitted and is pending approval.");
            }
        }
    </script>
</head>
<body>
      <!-- Sidebar -->
      <div class="sidebar">
    <li class="logo-container">
        <img src="../images/muse logo.png" alt="Muse Bookstore Logo">
    </li>
    <nav>
        <ul>
            <li class="active"><a href="user.php"><i class="fas fa-tachometer-alt"></i> Welcome to dashboard</a></li>
            <li><a href="userprofile.php"><i class="fas fa-user"></i> Profile</a></li>
            <li><a href="books.php"><i class="fas fa-book"></i> Books</a></li>
            <li><a href="communities.php"><i class="fas fa-users"></i> Communities</a></li>
            <li><a href="blogs.php"><i class="fas fa-blog"></i> Blogs</a></li>
            <li><a href="writing-groups.php"><i class="fas fa-pen"></i> Writing Groups</a></li>
            <li><a href="#"><i class="fas fa-envelope"></i> Messages</a></li>
        </ul>
        <ul>
            <li><a href="my-books.php"><i class="fas fa-bookmark"></i> My Books</a></li>
            <li><a href="calendar.php"><i class="fas fa-calendar-alt"></i> Calendar</a></li>
            <li><a href="wishlist.php"><i class="fas fa-heart"></i> Wish-list</a></li>
            <li><a href="wishlist.php"><i class="fas fa-bell"></i> Notifications</a></li>
            <li><a href="#"><i class="fas fa-shopping-cart"></i> Cart</a></li>
            <li><a href="../includes/logout.inc.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </nav>
</div>
    <div class="container">
        <h1>Request Deletion for "<?php echo htmlspecialchars($community['community_name']); ?>"</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="community_id">Community ID:</label>
                <input type="text" id="community_id" value="<?php echo htmlspecialchars($community['community_id']); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="community_name">Community Name:</label>
                <input type="text" id="community_name" value="<?php echo htmlspecialchars($community['community_name']); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="community_description">Community Description:</label>
                <textarea id="community_description" readonly><?php echo htmlspecialchars($community['community_description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="username">Your Username:</label>
                <input type="text" id="username" value="<?php echo htmlspecialchars($username); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="reason">Reason for Deletion:</label>
                <textarea name="reason" id="reason" required placeholder="Provide your reason for deletion"></textarea>
            </div>
            <button type="submit">Submit Request</button>
        </form>
    </div>
</body>
</html>

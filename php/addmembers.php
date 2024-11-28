<?php
session_start();
require_once '../classes/community.classes.php';
require_once '../classes/user.classes.php';

// Check if community_id is provided in the URL
if (isset($_GET['community_id'])) {
    $communityId = $_GET['community_id'];
} else {
    header("Location: communities.php?error=nocommunityid"); // Redirect if no community_id is provided
    exit();
}

// Initialize the Community object and fetch community details
$communityObj = new Community();
$community = $communityObj->getCommunityById($communityId);

// If community doesn't exist, redirect to communities page
if (!$community) {
    header("Location: communities.php?error=communitynotfound");
    exit();
}

// Handle form submission for adding a new member
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];

    // Add member to the community
    if ($communityObj->addMemberToCommunity($communityId, $userId)) {
        $success = "Member added successfully!";
    } else {
        $error = "Failed to add member. Please try again.";
    }
}

// Fetch all users (assuming you have a User class to fetch user details)
$userObj = new User();
$users = $userObj->getAllUsers();

// Fetch members of the community
$members = $communityObj->getCommunityMembers($communityId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Members to <?php echo htmlspecialchars($community['community_name']); ?></title>
    <link rel="stylesheet" href="../css/add_members.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Add Members to <?php echo htmlspecialchars($community['community_name']); ?></h1>

        <?php if (isset($success)): ?>
            <p class="success"><?php echo htmlspecialchars($success); ?></p>
        <?php elseif (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="user_id">Select User:</label>
            <select name="user_id" id="user_id" required>
                <option value="">-- Select a User --</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?php echo htmlspecialchars($user['users_id']); ?>">
                        <?php echo htmlspecialchars($user['users_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="add-member-btn">Add Member</button>
        </form>

        <h2>Community Members</h2>
        <table class="members-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($members)): ?>
                    <?php foreach ($members as $member): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($member['name']); ?></td>
                            <td><?php echo htmlspecialchars($member['email']); ?></td>
                            <td>
                                <a href="remove_member.php?community_id=<?php echo $communityId; ?>&user_id=<?php echo $member['id']; ?>" class="remove-btn" onclick="return confirm('Are you sure you want to remove this member?');">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No members in this community.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="community_details.php?community_id=<?php echo $communityId; ?>" class="back-btn">Back to Community</a>
    </div>
</body>
</html>

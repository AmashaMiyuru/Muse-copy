<?php
session_start();
require_once '../classes/writingGroup.classes.php';
require_once '../classes/chapter.classes.php';

// Handle post creation when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $groupId = $_POST['group_id'];
    $chapterTitle = $_POST['chapter_title'];
    $chapterContent = $_POST['chapter_content'];
    $author = $_SESSION['username']; // Assuming a session stores the logged-in user's username

    if (!empty($groupId) && !empty($chapterTitle) && !empty($chapterContent)) {
        $chapersObj = new Chapter();
        if ($chapersObj->createPost($groupId, $chapterTitle, $chapterContent, $author)) {
            header("Location: writing_group_posts.php?group_id=$groupId&success=chaptercreated");
        } else {
            header("Location: writing_group_posts.php?group_id=$groupId&error=creationfailed");
        }
    } else {
        header("Location: writing_group_posts.php?group_id=$groupId&error=invalidinput");
    }
    exit();
}

// Check if group_id is provided in the URL
if (isset($_GET['group_id'])) {
    $groupId = $_GET['group_id'];
} else {
    header("Location: writing_groups.php?error=nogroupid");
    exit();
}

// Initialize the WritingGroups and Posts objects
$writingGroupsObj = new WritingGroups();
$postsObj = new Chapter();

// Fetch writing group details
$writingGroup = $writingGroupsObj->getWritingGroupsByCommunityId($groupId);
if (!$writingGroup) {
    header("Location: writing_groups.php?error=groupnotfound");
    exit();
}
$writingGroup = $writingGroupsObj->getWritingGroupById($groupId);
if (!$writingGroup) {
    header("Location: writing_groups.php?error=groupnotfound");
    exit();
}

// Fetch posts (chapters) for the writing group
$chapters = $postsObj->getPostsByGroupId($groupId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($writingGroup['name']); ?> - Chapters</title>
    <link rel="stylesheet" href="../css/chapters.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <div class="writing-group-posts-container">
        <h1><?php echo htmlspecialchars($writingGroup['name']); ?> - Chapters</h1>
        <button id="create-chapter-btn" class="create-chapter-btn">Create Chapter</button>

        <!-- Display success or error messages -->
        <?php if (isset($_GET['success'])): ?>
            <p class="success-message">Chapter created successfully!</p>
        <?php elseif (isset($_GET['error'])): ?>
            <p class="error-message">
                <?php
                switch ($_GET['error']) {
                    case 'creationfailed':
                        echo "Failed to create the chapter. Please try again.";
                        break;
                    case 'invalidinput':
                        echo "Please fill in all the required fields.";
                        break;
                    default:
                        echo "An error occurred. Please try again.";
                        break;
                }
                ?>
            </p>
        <?php endif; ?>

        <!-- Chapters List -->
        <div class="chapters-list">
            <?php if (!empty($chapters)): ?>
                <?php foreach ($chapters as $index => $chapter): ?>
                    <div class="chapter">
                        <img src="../images/writing_group2.jpg">
                        <h2>Chapter <?php echo $index + 1; ?>: <?php echo htmlspecialchars($chapter['title']); ?></h2>
                        <p><?php echo nl2br(htmlspecialchars($chapter['content'])); ?></p>
                        <p class="author">By: <?php echo htmlspecialchars($chapter['author']); ?></p>
                        <p class="timestamp">Posted on: <?php echo htmlspecialchars($chapter['created_at']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No chapters found. Start by creating the first chapter!</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Create Chapter Modal -->
    <div id="create-chapter-modal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Create Chapter</h2>
            <form id="create-chapter-form" method="POST" action="">
                <input type="hidden" name="group_id" value="<?php echo $groupId; ?>">
                <label for="chapter_title">Chapter Title:</label>
                <input type="text" id="chapter_title" name="chapter_title" required>
                <label for="chapter_content">Chapter Content:</label>
                <textarea id="chapter_content" name="chapter_content" rows="10" required></textarea>
                <button type="submit" class="submit-btn">Create</button>
            </form>
        </div>
    </div>

    <script src="../js/writing_group_posts.js"></script>
</body>
</html>

<?php
session_start();

// Handle errors from the previous submission
if (isset($_GET['error'])) {
    $error = $_GET['error'];
} else {
    $error = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="../css/userprofile.css">
    <link rel="stylesheet" href="../css/calendar.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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


    <!-- Main content -->
    <div class="main-content">
        <div class="profile-container">
            <h1>My events</h1><br>

            <form method="POST" action="#" class="event-form">
               <label for="eventname">Event Name:</label>
               <input type="text" id="eventname" name="eventname" placeholder="Enter event name">

               <label for="description">Event Description:</label>
               <input type="text" id="description" name="description" placeholder="Brief event description">

               <label for="location">Location:</label>
               <input type="text" id="location" name="location" placeholder="Event location">

               <label for="eventdate">Date:</label>
               <input type="date" id="eventdate" name="eventdate" min="<?php echo date('Y-m-d'); ?>">

               <label for="eventtime">Time:</label>
               <input type="time" id="eventtime" name="eventtime">

               <!-- Submit button with styling class -->
               <button type="submit" class="addevent-btn">Save Event</button>
            </form>

        </div>
    </div>
</body>
</html>

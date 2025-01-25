<?php
include 'config.php';
include 'includes/header.php';

session_start();

$user_id = $_GET['id'];

// استرجاع بيانات المستخدم
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if ($user) {
    echo "Username: " . $user['username'] . "<br>";
    echo "Gender: " . $user['gender'] . "<br>";
    echo "<img src='" . $user['profile_picture'] . "' alt='Profile Picture'><br>";

    // إذا كان المستخدم مسجلاً، عرض زر التراسل
    if (isset($_SESSION['user_id'])) {
        echo "<a href='chat.php?user_id=" . $user['id'] . "'>Start Chat</a><br>";
    } else {
        echo "<p>You must be logged in to send a message.</p>";
    }

    // إذا كان المستخدم مسجلاً، عرض زر تعديل الملف الشخصي
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user['id']) {
        echo "<a href='edit_profile.php'>Edit Profile</a><br>";
        echo "<form method='post' action='logout.php'>
                <input type='submit' value='Logout'>
              </form>";
    }
} else {
    echo "User not found.";
}

include 'includes/footer.php';
?> 
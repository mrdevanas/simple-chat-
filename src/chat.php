<?php
include 'config.php';
include 'includes/header.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Set sender_id to the current user's ID
$sender_id = $_SESSION['user_id'];

// Ensure receiver_id is set and valid
$receiver_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($receiver_id <= 0) {
    echo "Invalid user ID.";
    exit();
}

// Retrieve the connected user's data
$sql_user = "SELECT * FROM users WHERE id = $receiver_id";
$result_user = mysqli_query($conn, $sql_user);
if (!$result_user) {
    echo "Error retrieving user: " . mysqli_error($conn);
    exit();
}
$user = mysqli_fetch_assoc($result_user);

// Send message
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    $message = $_POST['message'];
    $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ('$sender_id', '$receiver_id', '$message')";
    
    if (mysqli_query($conn, $sql)) {
        // Message sent successfully
        header("Location: chat.php?user_id=" . $receiver_id); // Redirect to avoid resending the message
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Retrieve messages
$sql = "SELECT * FROM messages WHERE (sender_id = '$sender_id' AND receiver_id = '$receiver_id') OR (sender_id = '$receiver_id' AND receiver_id = '$sender_id') ORDER BY timestamp ASC";
$result = mysqli_query($conn, $sql);

// Retrieve currently online users
$sql_online = "SELECT * FROM users WHERE is_online = 1"; // Retrieve only online users
$result_online = mysqli_query($conn, $sql_online);
?>

<h2>Chat with: <?php echo htmlspecialchars($user['username']); ?></h2>

<!-- Button to go to your own profile -->
<a href="profile.php?id=<?php echo $sender_id; ?>" style="margin-bottom: 10px; display: inline-block; padding: 5px 10px; background-color: #007bff; color: white; border-radius: 5px; text-decoration: none;">Go to My Profile</a>

<!-- Display currently online users -->
<h3>Currently Online Users:</h3>
<ul>
    <?php while ($user_online = mysqli_fetch_assoc($result_online)): ?>
        <li>
            <a href="chat.php?user_id=<?php echo $user_online['id']; ?>"><?php echo htmlspecialchars($user_online['username']); ?></a>
        </li>
    <?php endwhile; ?>
</ul>

<!-- Search for users -->
<h3>Search for Users:</h3>
<form method="get" action="search.php">
    <input type="text" name="query" placeholder="Search for a user...">
    <input type="submit" value="Search">
</form>

<!-- Chat box -->
<div class="chat-box">
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="<?php echo $row['sender_id'] == $sender_id ? 'message-sent' : 'message-received'; ?>">
            <strong><?php echo $row['sender_id'] == $sender_id ? 'You' : htmlspecialchars($user['username']); ?>:</strong>
            <p><?php echo htmlspecialchars($row['message']); ?></p>
            <small><?php echo $row['timestamp']; ?></small>
            <!-- Delete message button -->
            <?php if ($row['sender_id'] == $sender_id): ?>
                <form method="post" action="delete_message.php" style="display:inline ; ">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="submit" value="Delete" >
                </form>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</div>

<form method="post">
    <input type="text" name="message" required placeholder="Type your message here...">
    <input type="submit" value="Send">
</form>

<?php
include 'includes/footer.php';
?> 
<?php
include 'config.php';
include 'includes/header.php';

$query = $_GET['query'] ?? '';

// استرجاع المستخدمين بناءً على الاستعلام
$sql = "SELECT * FROM users WHERE username LIKE '%$query%'";
$result = mysqli_query($conn, $sql);
?>

<h2 style="color:green">Search results for : <?php  echo htmlspecialchars($query); ?></h2>
<ul >
    <?php while ($user = mysqli_fetch_assoc($result)): ?>
        <li>
            <?php echo $user['username']; ?>
            <a href="chat.php?user_id=<?php echo $user['id']; ?>">Start Chat</a>
        </li>
    <?php endwhile; ?>
</ul>

<?php
include 'includes/footer.php';
?> 
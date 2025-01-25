<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $message_id = $_POST['id'];
    $sql = "DELETE FROM messages WHERE id = $message_id";

    if (mysqli_query($conn, $sql)) {
        header("Location: chat.php?user_id=" . $_GET['user_id']); // إعادة توجيه إلى صفحة الدردشة
        exit();
    } else {
        echo "Error deleting message: " . mysqli_error($conn);
    }
}
?> 
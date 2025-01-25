<?php
include 'config.php';
include 'includes/header.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        
        // تحديث حالة الاتصال
        $sql_update = "UPDATE users SET is_online = 1 WHERE id = " . $user['id'];
        mysqli_query($conn, $sql_update);
        
        header("Location: profile.php?id=" . $user['id']);
        exit();
    } else {
        echo "<p style='color: red;'>Invalid username or password.</p>";
    }
}
?>

<div class="container">
    <form method="post">
        <input type="text" name="username" required placeholder="username ">
        <input type="password" name="password" required placeholder="password">
        <input type="submit" value="Log in">
    </form>
    <p>if U Don't have an account!  <a href="signup.php"> You can Register now</a></p>
</div>

<?php
include 'includes/footer.php';
?> 
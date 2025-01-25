<?php
include 'config.php';
include 'includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $gender = $_POST['gender'];
    $profile_picture = $_POST['profile_picture'];

    $sql = "INSERT INTO users (username, password, gender, profile_picture) VALUES ('$username', '$password', '$gender', '$profile_picture')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<p style='color: green;'>Registration successful!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<div class="container">
    <form method="post">
        <input type="text" name="username" required placeholder="username ">
        <input type="password" name="password" required placeholder="password">
        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="male">Female</option>
            <option value="female">male</option>
        </select>
        <input type="text" name="profile_picture" placeholder="Image link ">
        <input type="submit" value="Log in">
    </form>
    <p>Already have an account?<a href="login.php">Log in</a></p>
</div>

<?php
include 'includes/footer.php';
?> 
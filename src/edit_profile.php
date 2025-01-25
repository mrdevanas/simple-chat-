<?php
include 'config.php';
include 'includes/header.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// استرجاع بيانات المستخدم
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// تحديث بيانات المستخدم
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $gender = $_POST['gender'];
    $profile_picture = $_POST['profile_picture'];

    $sql = "UPDATE users SET username='$username', gender='$gender', profile_picture='$profile_picture' WHERE id=$user_id";

    if (mysqli_query($conn, $sql)) {
        echo "Profile updated successfully!";
        header("Location: profile.php?id=" . $user_id); // إعادة توجيه إلى صفحة الملف الشخصي
        exit();
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}
?>

<h2>Edit Profile</h2>
<form method="post">
    Username: <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br>
    Gender: 
    <select name="gender">
        <option value="male" <?php if ($user['gender'] == 'male') echo 'selected'; ?>>Male</option>
        <option value="female" <?php if ($user['gender'] == 'female') echo 'selected'; ?>>Female</option>
    </select><br>
    Profile Picture URL: <input type="text" name="profile_picture" value="<?php echo $user['profile_picture']; ?>"><br>
    <input type="submit" value="Update Profile">
</form>

<?php
include 'includes/footer.php';
?> 
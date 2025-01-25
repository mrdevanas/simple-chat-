<?php
include 'config.php'; // Ensure the database connection is included

session_start(); // بدء جلسة العمل

// تحديث حالة الاتصال
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql_update = "UPDATE users SET is_online = 0 WHERE id = $user_id";
    mysqli_query($conn, $sql_update);
}

session_destroy(); // تدمير الجلسة الحالية
header("Location: login.php"); // إعادة توجيه المستخدم إلى صفحة تسجيل الدخول
exit(); // إنهاء السكربت
?> 
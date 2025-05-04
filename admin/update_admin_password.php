<?php
require_once 'config/db_config.php'; // Adjust the path if needed

$username = 'admin';
$new_password = 'admin123'; // **CHANGE THIS TO A STRONG PASSWORD!**
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

$sql = "UPDATE admin_users SET password = ? WHERE username = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $username);

if (mysqli_stmt_execute($stmt)) {
    echo "Admin password for user '" . $username . "' has been updated successfully to the hashed version of '" . $new_password . "'.";
    echo "<br><strong>Remember to delete this script after running it!</strong>";
} else {
    echo "Error updating password: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
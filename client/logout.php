<?php
// Perform any necessary actions to invalidate the user's session
session_start();
session_destroy(); // Destroy the session data

// Redirect the user to the appropriate page after logging out
header("Location: index.php"); // Replace "index.php" with your desired redirect URL
exit();
?>
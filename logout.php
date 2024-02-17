<?php
session_start();
session_destroy(); // Destroy all session data

// Redirect to the login page after logout
header("Location: index.php");
exit();
?>
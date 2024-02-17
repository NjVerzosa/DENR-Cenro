<?php
session_start();
include 'config.php';

if (!isset($_SESSION["email"])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
    
} elseif ($_SESSION['role'] == "Admin") {
    header("Location: index.php"); // Redirect to login page if the logged in User is attempting to access the Unauthorized Page(s) by URL
    exit();
}
?>
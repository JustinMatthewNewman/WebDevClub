<?php
// Initialize the session
session_start();
require_once "config.php";

// Unset all of the session variables
$id = $_SESSION['id'];
$query = $pdo->prepare("UPDATE users SET `status` = 0 WHERE id = $id ");
$query->execute(); 
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: login.php");
exit;
?>
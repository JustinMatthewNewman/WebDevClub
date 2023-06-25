<?php 
require_once "config.php";
session_start();

$msgToken = $_POST['msgid'];
$query = $pdo->prepare("DELETE FROM messages WHERE msg_id=$msgToken");
$query->execute(); 
     ?>
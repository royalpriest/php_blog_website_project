<?php
session_name("HUB_SESSION");
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Access denied");
}

require_once './classes/database.php';
require_once './classes/content.php';

$db = (new Database())->connect();
$content = new Content($db);

if (isset($_GET['id'])) {
    $content->delete($_GET['id']);
}

header("Location: about.php");
exit;
?>
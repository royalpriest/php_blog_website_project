<?php
session_name("HUB_SESSION");
session_start();
if(!isset($_SESSION['user_id'])) {
    die("Access denied");
}

require_once './classes/database.php';
require_once './classes/user.php';

$db = (new Database())->connect();
$user = new User($db);

if(isset($_GET['id'])) {
    // Check if user exists first
    $userToDelete = $user->getById($_GET['id']);
    if(!$userToDelete) {
        $_SESSION['error'] = "User not found";
        header('Location: users.php');
        exit;
    }

    // Prevent deleting yourself
    if($_GET['id'] == $_SESSION['user_id']) {
        $_SESSION['error'] = "You cannot delete your own account";
        header('Location: users.php');
        exit;
    }

    // Attempt deletion
    if($user->delete($_GET['id'])) {
        $_SESSION['message'] = "User deleted successfully";
    } else {
        $_SESSION['error'] = "Failed to delete user. It might be referenced by other data.";
    }
} else {
    $_SESSION['error'] = "No user ID specified";
}

header('Location: users.php');
exit;
?>
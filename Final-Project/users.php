<?php
// Start session and check if user is logged in
session_name("HUB_SESSION");
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location:login.php");
    exit;
}

// page metadata
$pageTitle = "User Management";
$pageDescription = "Admin dashboard displaying all registered users";

// Include required files
require './inc/header.php';
require_once './classes/database.php';
require_once './classes/user.php';

// Initialize database connection
$db = (new Database())->connect();
$user = new User($db);

// Fetch all users from database
$users = $user->readAll();
?>

    <!-- Admin dashboard header section -->
    <section class="users-header">
        <div class="users-content">
            <h1>Users Hub</h1>

            <!-- Display welcome message with username -->
            <div class="user-name">
                <p>Welcome, <?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></p>
            </div>

            <!-- Admin action buttons -->
            <div class="welcome-message">
                <div class="admin-buttons">
                    <a href="user_creation.php" class="create-btn">Create User</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Display session messages if they exist -->
<?php if(isset($_SESSION['message'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['message']) ?></div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

    <!-- Main users table section -->
    <section class="users-container">
        <div class="users-card">
            <table class="users-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Profile</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <!-- Loop through each user and display their information -->
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td class="profile-picture">
                            <!-- Display profile picture if exists, otherwise show default avatar -->
                            <?php if (!empty($user['profile_picture'])): ?>
                                <img src="uploads/<?= htmlspecialchars($user['profile_picture']) ?>" alt="Profile Picture">
                            <?php else: ?>
                                <div class="default-avatar">
                                    <?= strtoupper(substr($user['name'], 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td class="actions-btn">
                            <!-- Edit and Delete action buttons -->
                            <a href="user_update.php?id=<?= $user['id'] ?>" class="edit-btn">Edit</a>
                            <a href="user_deletion.php?id=<?= $user['id'] ?>" class="delete-btn"
                               onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

<?php require './inc/footer.php'; ?>
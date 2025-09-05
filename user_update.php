<?php

$pageTitle = "Update User ";
$pageDescription = "This page will allow for the edit or updating of existing users.";

session_name("HUB_SESSION");
session_start();
if(!isset($_SESSION['user_id'])){
    die("Access denied!");
}

require './inc/header.php';
require_once './classes/database.php';
require_once './classes/user.php';
require_once './classes/validateInfo.php';

$db = (new Database())->connect();
$validator = new ValidateInfo();
$user = new User($db);

// Get user data if ID is provided
$currentUser = null;
if(isset($_GET['id'])) {
    $currentUser = $user->getById($_GET['id']);
    if(!$currentUser) {
        header("Location: users.php");
        exit;
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST['id'];
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = !empty($_POST['password']) ? $_POST['password'] : null;
    $error = '';

    // Validate fields
    $requiredFields = ['name', 'email'];
    $emptyErrors = $validator->checkEmpty($_POST, $requiredFields);

    $nameError = $validator->validateName($name);
    $emailError = $validator->validateEmail($email);

    if (!empty($password)) {
        $passwordError = $validator->validatePassword($password);
        if ($passwordError) {
            $error = $passwordError;
        }
    }

    if (!empty($emptyErrors)) {
        $error = implode("<br>", $emptyErrors);
    } elseif ($nameError) {
        $error = $nameError;
    } elseif ($emailError) {
        $error = $emailError;
    } elseif ($email !== $currentUser['email'] && $validator->isEmailExists($email, $db)) {
        $error = "Email already exists";
    }

    if (empty($error)) {
        // Handle profile picture upload
        $profile_picture = $currentUser['profile_picture'];
        if (!empty($_FILES['profile_picture']['name'])) {
            $profile_picture = time() . '_' . basename($_FILES['profile_picture']['name']);
            move_uploaded_file($_FILES['profile_picture']['tmp_name'], "uploads/" . $profile_picture);
        }

        $user->update($id, $name, $email, $password, $profile_picture);
        header("Location: users.php");
        exit;
    }
}
?>
    <div class="user-title">
        <h2>Edit User</h2>
    </div>
    <section class="form-container">
        <div class="form-card">
            <?php if($currentUser): ?>
                <form method="post" action="user_update.php" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($currentUser['id']) ?>">

                    <div class="form-info">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?= htmlspecialchars($currentUser['name']) ?>" required>
                    </div>

                    <div class="form-info">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($currentUser['email']) ?>" required>
                    </div>

                    <!-- Password field -->
                    <div class="form-info">
                        <label for="password">New Password (leave empty to keep current):</label>
                        <div class="password-container">
                            <input type="password" id="password" name="password" class="password-field" placeholder="password must be at least 8 characters..." >

                            <button type="button" class="password-toggle" data-toggle="password" onclick="togglePassword('password')">
                                <svg class="eye-open" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <svg class="eye-closed hidden" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                    <line x1="1" y1="1" x2="23" y2="23"></line>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="form-info">
                        <label for="profile_picture">Profile Picture:</label>
                        <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
                        <?php if(!empty($currentUser['profile_picture'])): ?>
                            <p>Current: <?= htmlspecialchars($currentUser['profile_picture']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="form-action">
                        <input type="submit" value="Update User">
                        <a href="users.php" class="cancel-btn">Cancel</a>
                    </div>


                </form>
            <?php else: ?>
                <p>User not found.</p>
                <a href="users.php">Back to Users</a>
            <?php endif; ?>
        </div>
    </section>

<?php require './inc/footer.php'; ?>
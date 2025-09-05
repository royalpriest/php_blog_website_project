<?php
// page metadata
$pageTitle = "User Registration Page";
$pageDescription = "This page allows for user registration";


require './inc/header.php';
require_once './classes/database.php';
require_once './classes/user.php';
require_once './classes/validateInfo.php';

// Initialize variables
$error = '';
$validator = new ValidateInfo();
$db = (new Database())->connect();

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data with null coalescing for safety
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $profile_picture = ''; // Default empty profile picture

    // Validate required fields
    $requiredFields = ['name', 'email', 'password', 'confirm_password'];
    $emptyErrors = $validator->checkEmpty($_POST, $requiredFields);

    // Validate field formats
    $nameError = $validator->validateName($name);
    $emailError = $validator->validateEmail($email);
    $passwordError = $validator->validatePassword($password);

    // Check for validation errors
    if ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } elseif (!empty($emptyErrors)) {
        $error = implode("<br>", $emptyErrors);
    } elseif ($nameError) {
        $error = $nameError;
    } elseif ($emailError) {
        $error = $emailError;
    } elseif ($passwordError) {
        $error = $passwordError;
    } elseif ($validator->isEmailExists($email, $db)) {
        $error = "Email already registered";
    } else {
        // Handle profile picture upload if provided
        if (!empty($_FILES['profile_picture']['name'])) {
            $profile_picture = time() . '_' . basename($_FILES['profile_picture']['name']);
            $target_dir = "uploads/";
            $target_file = $target_dir . $profile_picture;

            // Simple file upload without image validation
            if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
                $error = "Error uploading profile picture";
            }
        }

        // Register user if no errors
        if (empty($error)) {
            $user = new User($db);
            if ($user->register($name, $email, $password, $profile_picture)) {
                header("Location: login.php");
                exit;
            } else {
                $error = "Registration Error";
            }
        }
    }
}
?>

    <!-- Page header section -->
    <div class="user-title">
        <h2>Fill the form below</h2>
    </div>

    <!-- Main form container -->
    <section class="form-container">
        <div class="form-card">
            <!-- Display error message if any -->
            <?php if (!empty($error)): ?>
                <div class="error-message"><?= $error ?></div>
            <?php endif; ?>

            <!-- Registration form -->
            <form method="post" action="register.php" enctype="multipart/form-data">
                <!-- Name input field -->
                <div class="form-info">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" placeholder="John Smith" required>
                </div>

                <!-- Email input field -->
                <div class="form-info">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="john@gmail.com" required>
                </div>

                <!-- Password field with visibility toggle -->
                <div class="form-info">
                    <label for="password">Password:</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" class="password-field"
                               placeholder="password must be at least 8 characters..." required>

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

                <!-- Password confirmation field -->
                <div class="form-info">
                    <label for="confirm_password">Confirm Password:</label>
                    <div class="password-container">
                        <input type="password" id="confirm_password" name="confirm_password" class="password-field" required>
                        <button type="button" class="password-toggle" data-toggle="confirm_password" onclick="togglePassword('confirm_password')">
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

                <!-- Profile picture upload -->
                <div class="form-info">
                    <label for="profile_picture">Profile Picture:</label>
                    <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
                </div>

                <!-- Form submission button -->
                <div class="form-action">
                    <input type="submit" name="submit" value="Register">
                </div>

                <!-- Login link -->
                <div class="form-footer">
                    <p>Already have an account? <a href="login.php">Login here</a></p>
                </div>
            </form>
        </div>
    </section>

<?php require './inc/footer.php'; ?>
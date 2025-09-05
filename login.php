<?php
// Start session
session_name("HUB_SESSION");
session_start();
$pageTitle = "Login Page";
$pageDescription = "This page allows users to login to our application.";

// require the necessary php classes and files
require './inc/header.php';
require_once './classes/database.php';
require_once './classes/user.php';
require_once './classes/validateInfo.php';

// Initialize validator
$validator = new ValidateInfo();
$error = '';

// Process form submission
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data with null coalescing for safety
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate input fields
    $requiredFields = ['email', 'password'];
    $emptyErrors = $validator->checkEmpty($_POST, $requiredFields);
    $emailError = $validator->validateEmail($email);

    // Handle validation errors
    if (!empty($emptyErrors)) {
        $error = implode("<br>", $emptyErrors);
    } elseif ($emailError) {
        $error = $emailError;
    } else {
        // Attempt login if validation passes
        $db = (new Database())->connect();
        $user = new User($db);

        $loginUser = $user->login($email, $password);
        if($loginUser){
            // Set session variables on successful login
            $_SESSION['user_id'] = $loginUser['id'];
            $_SESSION['username'] = $loginUser['name'];
            $_SESSION['email'] = $loginUser['email'];
            header("Location: users.php");
            exit;
        } else {
            $error = "Invalid Credentials";
        }
    }
}
?>

    <!-- Page header section -->
    <div class="user-title">
        <h2>Input Details</h2>
    </div>

    <!-- Main form container -->
    <section class="form-container">
        <div class="form-card">
            <!-- Display error message if any -->
            <?php if (!empty($error)): ?>
                <div class="error-message"><?= $error ?></div>
            <?php endif; ?>

            <!-- Login form -->
            <form method="post" action="login.php">
                <!-- Email input field -->
                <div class="form-info">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="john@gmail.com" required>
                </div>

                <!-- Password input field with toggle visibility -->
                <div class="form-info">
                    <label for="password">Password:</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" class="password-field"
                               placeholder="password must be at least 8 characters..." required>

                        <!-- Password visibility toggle button -->
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

                <!-- Form submission button -->
                <div class="form-action">
                    <input type="submit" name="submit" value="Login">
                </div>

                <!-- Registration link -->
                <div class="form-footer">
                    Don't have an account? <a href="register.php">Register here</a>
                </div>
            </form>
        </div>
    </section>

<?php require './inc/footer.php'; ?>
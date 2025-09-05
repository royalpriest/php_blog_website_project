<?php
// Redirect to login if user is not registered by checking session
session_name("HUB_SESSION");
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


require './inc/header.php';
require_once './classes/database.php';
require_once './classes/content.php';

// Initialize database connection
$db = (new Database())->connect();
$content = new Content($db);

// Process form when submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $image = ''; // Default empty image path

    // Handle image upload if file was provided
    if (!empty($_FILES['image']['name'])) {
        // Generate unique filename using timestamp
        $image = time() . '_' . basename($_FILES['image']['name']);
        $target_dir = "uploads/content/";
        $target_file = $target_dir . $image;

        // Move uploaded file to target directory
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $error = "Error uploading image file";
        }
    }

    // Create post if no errors occurred
    if (!isset($error)) {
        if ($content->create($_SESSION['user_id'], $title, $body, $image)) {
            header("Location: about.php");
            exit;
        } else {
            $error = "Failed to create post";
        }
    }
}
?>

    <!-- Page header section -->
    <div class="form-title">
        <h2>Create New Post</h2>
    </div>

    <!-- Main content form section -->
    <section class="content-form">
        <div class="update-container">
            <!-- Display error message if any -->
            <?php if (isset($error)): ?>
                <div class="error-message"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <!-- Post creation form -->
            <form method="POST" enctype="multipart/form-data">
                <!-- Title input field -->
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required>
                </div>

                <!-- Content textarea -->
                <div class="form-group">
                    <label for="body">Content:</label>
                    <textarea id="body" name="body" rows="5" required></textarea>
                </div>

                <!-- Optional image upload -->
                <div class="form-group image-upload">
                    <label for="image">Image (optional):</label>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>

                <!-- Form submission button -->
                <div class="content-update">
                    <button type="submit" class="btn-submit">Publish</button>
                    <a href="about.php" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </section>

<?php require './inc/footer.php'; ?>
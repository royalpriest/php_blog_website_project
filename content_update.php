<?php
// Start session and check if the user is logged in
session_name("HUB_SESSION");
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require './inc/header.php';
require_once './classes/database.php';
require_once './classes/content.php';

// Initialize database
$db = (new Database())->connect();
$content = new Content($db);

// Retrieve existing post data
$post = $content->getById($_GET['id'] ?? 0);
if (!$post) {
    header("Location: content.php");
    exit;
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $image = $post['image']; // Keep current image by default

    // Handle new image upload if provided
    if (!empty($_FILES['image']['name'])) {
        $image = time() . '_' . basename($_FILES['image']['name']);
        $target_dir = "uploads/content/";
        $target_file = $target_dir . $image;

        // Simple file upload without image validation
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $error = "Error uploading image file";
        }
    }

    // Update post if no errors occurred
    if (!isset($error)) {
        if ($content->update($post['id'], $title, $body, $image)) {
            header("Location: about.php");
            exit;
        } else {
            $error = "Failed to update post";
        }
    }
}
?>

    <!-- Page header section -->
    <div class="form-title">
        <h2>Edit Post</h2>
    </div>

    <!-- Main edit form section -->
    <section class="content-form">
        <div class="update-container">
            <!-- Display error message if any -->
            <?php if (isset($error)): ?>
                <div class="error-message"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <!-- Post edit form -->
            <form method="POST" enctype="multipart/form-data">
                <!-- Title input field -->
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>
                </div>

                <!-- Content textarea -->
                <div class="form-group">
                    <label for="body">Content:</label>
                    <textarea id="body" name="body" rows="5" required><?= htmlspecialchars($post['body']) ?></textarea>
                </div>

                <!-- Image upload section -->
                <div class="form-group image-upload">
                    <!-- Display current image if exists -->
                    <?php if ($post['image']): ?>
                        <label>Current Image:</label>
                        <img src="uploads/content/<?= htmlspecialchars($post['image']) ?>" class="current-image" width="200">
                        <small>Leave blank to keep current image</small>
                    <?php endif; ?>

                    <!-- New image upload option -->
                    <label for="new-image">New Image (optional):</label>
                    <input type="file" id="new-image" name="image" accept="image/*">
                </div>

                <!-- Form submission button -->
                <div class="content-update">
                    <button type="submit" class="btn-submit">Update Post</button>
                    <a href="about.php" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </section>

<?php require './inc/footer.php'; ?>
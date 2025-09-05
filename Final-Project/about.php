<?php
session_name("HUB_SESSION");
session_start();
$pageTitle = "Programmer Hub Content";       // Page title for header
$pageDescription = "Browse all community posts and tutorials";  // Meta description

require './inc/header.php';                 // Include header template
require_once './classes/database.php';       // Database connection class
require_once './classes/content.php';       // Content management class

// Initialize database and content objects
$db = (new Database())->connect();
$content = new Content($db);

// Get all content from database
$contents = $content->readAll();
?>

<!-- Platform features section -->
<section class="platform-features">
    <h2 class="features-title">Right here on this page:</h2>
    <ul class="feature-list">
        <li>You can Post and share code snippets.</li>
        <li>You can ask technical questions and get expert answers.</li>
        <li>You can collaborate with other developers in real-time.</li>
        <li>You can browse through an archive of proven solutions.</li>
    </ul>
</section>

<!-- Main content display section -->
<section class="content-page">
    <div class="content-header">
        <h1>Community Posts</h1>

        <?php if (isset($_SESSION['user_id'])): ?>  <!-- Show create button for logged-in users -->
            <a href="content_creation.php" class="btn create-btn">+ New Post</a>
        <?php endif; ?>
    </div>

    <!-- Content grid - displays all posts -->
    <div class="content-grid">
        <?php if (empty($contents)): ?>  <!-- Show message if no content exists -->
            <p class="no-content">No content available yet. Be the first to share!</p>
        <?php else: ?>
            <?php foreach ($contents as $post): ?>  <!-- Loop through each content item -->
                <article class="content-card">
                    <?php if ($post['image']): ?>  <!-- Display image if available -->
                        <div class="content-image">
                            <img src="uploads/content/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>">
                        </div>
                    <?php endif; ?>

                    <!-- Post content body -->
                    <div class="content-body">
                        <h2><?= htmlspecialchars($post['title']) ?></h2>
                        <p><?= nl2br(htmlspecialchars($post['body'])) ?></p>
                        <div class="content-meta">
                            <span class="post-date">Posted on <?= date('M j, Y', strtotime($post['created_at'])) ?></span>  <!-- Formatted date -->
                        </div>
                    </div>

                    <?php if (isset($_SESSION['user_id'])): ?>  <!-- Show actions for logged-in users -->
                        <div class="content-actions">
                            <a href="content_update.php?id=<?= $post['id'] ?>" class="edit-btn">Edit</a>  <!-- Edit link -->
                            <a href="content_deletion.php?id=<?= $post['id'] ?>" class="delete-btn"
                               onclick="return confirm('Delete this post permanently?')">Delete</a>  <!-- Delete with confirmation -->
                        </div>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<?php require './inc/footer.php'; ?>  <!-- Include footer template -->
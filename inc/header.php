
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription ?? 'Default description'); ?>" >
    <title><?php echo htmlspecialchars($pageTitle ?? 'Default Title'); ?></title>

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alumni+Sans+Pinstripe:ital@0;1&family=Oranienbaum&display=swap" rel="stylesheet">

    <!-- My custom stylesheet -->
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
<header>
    <div class="header-container">
        <!-- Main heading for the page -->
        <div class="logo-image">
            <img src="images/logo3.png" alt="logo" class="logo-icon">
        </div>
        <!-- Navigation bar -->
        <div>
            <nav>
                <ul class="nav-items">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="users.php">Users Hub</a></li>
                    <?php endif; ?>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <li><a href="register.php">Register</a></li>
                        <li><a href="login.php">Login</a></li>
                    <?php else: ?>
                        <li><a href="logout.php" >Logout</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</header>
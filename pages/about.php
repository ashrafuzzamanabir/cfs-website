<?php
require_once '../config/db_config.php';

// Get about page content
$sql = "SELECT * FROM about_page WHERE id = 1";
$result = mysqli_query($conn, $sql);
$about_content = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Chokh Film Society</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .about-container {
            padding: 2rem;
            margin-top: 60px;
        }
        .about-content {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .about-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .about-header h2 {
            color: var(--accent-color);
            margin-bottom: 1rem;
        }
        .about-text {
            line-height: 1.8;
            margin-bottom: 2rem;
        }
        .social-links {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        .social-link {
            display: inline-block;
            background: var(--accent-color);
            color: white;
            padding: 1rem 2rem;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .social-link:hover {
            background-color: #c4000f;
        }
        .social-link i {
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <h1>Chokh Film Society</h1>
        </div>
        <ul class="nav-links">
            <li><a href="../index.php">Home</a></li>
            <li><a href="about.php" class="active">About</a></li>
            <li><a href="committee.php">Committee</a></li>
            <li><a href="gallery.php">Gallery</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>

    <div class="about-container">
        <div class="about-content">
            <div class="about-header">
                <h2>About Chokh Film Society</h2>
                <p>Promoting Film Culture at SUST Since 2010</p>
            </div>
            
            <div class="about-text">
                <?php echo nl2br(htmlspecialchars($about_content['about_text'] ?? '')); ?>
            </div>
            
            <div class="social-links">
                <?php if (!empty($about_content['facebook_link'])): ?>
                    <a href="<?php echo htmlspecialchars($about_content['facebook_link']); ?>" target="_blank" class="social-link">
                        <i class="fab fa-facebook"></i> Facebook
                    </a>
                <?php endif; ?>
                <?php if (!empty($about_content['instagram_link'])): ?>
                    <a href="<?php echo htmlspecialchars($about_content['instagram_link']); ?>" target="_blank" class="social-link">
                        <i class="fab fa-instagram"></i> Instagram
                    </a>
                <?php endif; ?>
                <?php if (!empty($about_content['email_address'])): ?>
                    <a href="mailto:<?php echo htmlspecialchars($about_content['email_address']); ?>" class="social-link">
                        <i class="fas fa-envelope"></i> Email Us
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Chokh Film Society - SUST. All rights reserved. Built by <a href="https://www.facebook.com/Idealtech.dev" target="_blank">Ideal Tech Ltd.</a></p>
        </div>
    </footer>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html> 
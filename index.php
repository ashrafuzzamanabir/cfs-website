<?php
require_once 'config/db_config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chokh Film Society - SUST</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="logo">
            <img src="assets/images/cfs.jpg" alt="CFS Logo" class="logo-img">
            <h1>Chokh Film Society</h1>
        </div>
        <button class="mobile-menu-btn" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </button>
        <ul class="nav-links">
            <li><a href="index.php" class="active">Home</a></li>
            <li><a href="pages/about.php">About</a></li>
            <li><a href="pages/committee.php">Committee</a></li>
            <li><a href="pages/gallery.php">Gallery</a></li>
            <li><a href="pages/contact.php">Contact</a></li>
            <?php if(isset($_SESSION['admin_logged_in'])): ?>
                <li><a href="admin/dashboard.php">Admin</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Hero Section with Slideshow -->
    <section class="hero">
        <div class="slideshow-container">
            <?php
            $sql = "SELECT e.*, g.image_path FROM events e 
                    LEFT JOIN gallery g ON e.id = g.event_id 
                    GROUP BY e.id 
                    ORDER BY e.event_date DESC LIMIT 5";
            $result = mysqli_query($conn, $sql);
            
            while($row = mysqli_fetch_assoc($result)) {
                echo '<div class="slide fade">';
                echo '<img src="' . $row['image_path'] . '" alt="' . $row['title'] . '">';
                echo '<div class="slide-caption">';
                echo '<h2>' . $row['title'] . '</h2>';
                echo '<p>' . substr($row['description'], 0, 150) . '...</p>';
                echo '</div>';
                echo '</div>';
            }
            ?>
            <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
            <a class="next" onclick="changeSlide(1)">&#10095;</a>
        </div>
    </section>

    <!-- Quick Links -->
    <section class="quick-links">
        <div class="container">
            <h2>Quick Links</h2>
            <div class="links-grid">
                <a href="https://www.facebook.com/cfssust" target="_blank" class="link-card">
                    <i class="fab fa-facebook"></i>
                    <span>Follow us on Facebook</span>
                </a>
                <a href="pages/gallery.php" class="link-card">
                    <i class="fas fa-images"></i>
                    <span>View Gallery</span>
                </a>
                <a href="pages/contact.php" class="link-card">
                    <i class="fas fa-envelope"></i>
                    <span>Contact Us</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Sponsors Section -->
    <section class="sponsors">
        <div class="container">
            <h2>Our Sponsors</h2>
            <div class="sponsors-grid">
                <?php
                $sql = "SELECT * FROM sponsors ORDER BY created_at DESC";
                $result = mysqli_query($conn, $sql);
                
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="sponsor-card">';
                    if($row['logo_path']) {
                        echo '<img src="' . htmlspecialchars($row['logo_path']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                    }
                    echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                    echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                    if($row['website_url']) {
                        echo '<a href="' . htmlspecialchars($row['website_url']) . '" target="_blank" class="sponsor-link">Visit Website</a>';
                    }
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Chokh Film Society - SUST. All rights reserved. Built by <a href="https://www.facebook.com/Idealtech.dev" target="_blank">Ideal Tech Ltd.</a></p>
        </div>
    </footer>

    <script src="assets/js/slideshow.js"></script>
    <script>
        function toggleMenu() {
            const navLinks = document.querySelector('.nav-links');
            navLinks.classList.toggle('active');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const navLinks = document.querySelector('.nav-links');
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            
            if (!navLinks.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
                navLinks.classList.remove('active');
            }
        });
    </script>
</body>
</html> 
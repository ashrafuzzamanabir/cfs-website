<?php
require_once '../config/db_config.php';

// Get contact information
$sql = "SELECT * FROM contact_info WHERE id = 1";
$result = mysqli_query($conn, $sql);
$contact_info = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Chokh Film Society</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .contact-container {
            padding: 2rem;
            margin-top: 60px;
        }
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        .contact-info {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .contact-info h2 {
            margin-bottom: 1.5rem;
            color: var(--accent-color);
        }
        .contact-item {
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
        }
        .contact-item i {
            margin-right: 1rem;
            color: var(--accent-color);
        }
        .map-container {
            height: 400px;
            border-radius: 8px;
            overflow: hidden;
        }
        @media (max-width: 768px) {
            .contact-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="../assets/images/cfs.jpg" alt="CFS Logo" class="logo-img">
            <h1>Chokh Film Society</h1>
        </div>
        <ul class="nav-links">
            <li><a href="../index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="committee.php">Committee</a></li>
            <li><a href="gallery.php">Gallery</a></li>
            <li><a href="contact.php" class="active">Contact</a></li>
        </ul>
    </nav>

    <div class="main-content">
        <div class="contact-container">
            <div class="contact-grid">
                <div class="contact-info">
                    <h2>Contact Information</h2>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h3>Location</h3>
                            <p><?php echo nl2br(htmlspecialchars($contact_info['location'] ?? '')); ?></p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h3>Email</h3>
                            <p><a href="mailto:<?php echo htmlspecialchars($contact_info['email'] ?? ''); ?>"><?php echo htmlspecialchars($contact_info['email'] ?? ''); ?></a></p>
                        </div>
                    </div>
                    <?php if (!empty($contact_info['phone'])): ?>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h3>Phone</h3>
                            <p><a href="tel:<?php echo htmlspecialchars($contact_info['phone'] ?? ''); ?>"><?php echo htmlspecialchars($contact_info['phone'] ?? ''); ?></a></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($contact_info['facebook_link'])): ?>
                    <div class="contact-item">
                        <i class="fab fa-facebook"></i>
                        <div>
                            <h3>Facebook</h3>
                            <p><a href="<?php echo htmlspecialchars($contact_info['facebook_link'] ?? ''); ?>" target="_blank">facebook.com/cfssust</a></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($contact_info['instagram_link'])): ?>
                    <div class="contact-item">
                        <i class="fab fa-instagram"></i>
                        <div>
                            <h3>Instagram</h3>
                            <p><a href="<?php echo htmlspecialchars($contact_info['instagram_link'] ?? ''); ?>" target="_blank">instagram.com/chokhfilmsociety</a></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="map-container">
                    <iframe 
                        src="<?php echo htmlspecialchars($contact_info['map_embed_url'] ?? ''); ?>"
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
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
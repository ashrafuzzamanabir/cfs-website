<?php
require_once '../config/db_config.php';
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
                            <p>Shahjalal University of Science and Technology<br>
                            Sylhet 3114, Bangladesh</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h3>Email</h3>
                            <p><a href="mailto:chokhfilmsociety@gmail.com">chokhfilmsociety@gmail.com</a></p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fab fa-facebook"></i>
                        <div>
                            <h3>Facebook</h3>
                            <p><a href="https://www.facebook.com/cfssust" target="_blank">facebook.com/cfssust</a></p>
                        </div>
                    </div>
                </div>
                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3618.8274566013213!2d91.83075931500685!3d24.91745498400939!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3750552bc91107d1%3A0x6e2a32d2bb0e5096!2sShahjalal%20University%20of%20Science%20and%20Technology!5e0!3m2!1sen!2sbd!4v1625147000000!5m2!1sen!2sbd"
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
<?php
require_once '../config/db_config.php';
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
                <p>Chokh Film Society is a vibrant cultural organization at Shahjalal University of Science and Technology (SUST), dedicated to promoting film culture and cinematic arts among students. Founded in 2010, we have been consistently working to create a platform for film enthusiasts to explore, discuss, and appreciate the art of cinema.</p>
                
                <p>Our activities include:</p>
                <ul>
                    <li>Regular film screenings and discussions</li>
                    <li>Film festivals and competitions</li>
                    <li>Workshops on filmmaking and cinematography</li>
                    <li>Cultural events and exhibitions</li>
                    <li>Collaboration with other film societies</li>
                </ul>
                
                <p>We believe in the power of cinema to inspire, educate, and bring people together. Our society provides a platform for students to showcase their creativity and develop their skills in filmmaking while fostering a community of film enthusiasts.</p>
            </div>
            
            <div style="text-align: center;">
                <a href="https://www.facebook.com/cfssust" target="_blank" class="social-link">
                    <i class="fab fa-facebook"></i>
                    Follow Us on Facebook
                </a>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Chokh Film Society - SUST. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html> 
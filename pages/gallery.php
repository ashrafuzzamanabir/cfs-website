<?php
require_once '../config/db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - Chokh Film Society</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <style>
        .gallery-container {
            padding: 2rem;
            margin-top: 60px;
        }
        .event-section {
            margin-bottom: 4rem;
        }
        .event-title {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--accent-color);
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .gallery-item:hover img {
            transform: scale(1.05);
        }
        .gallery-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 0.5rem;
            font-size: 0.9rem;
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
            <li><a href="gallery.php" class="active">Gallery</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>

    <div class="gallery-container">
        <?php
        $sql = "SELECT e.*, g.image_path, g.caption FROM events e 
                LEFT JOIN gallery g ON e.id = g.event_id 
                ORDER BY e.event_date DESC";
        $result = mysqli_query($conn, $sql);
        
        $current_event = null;
        while($row = mysqli_fetch_assoc($result)) {
            if($current_event !== $row['id']) {
                if($current_event !== null) {
                    echo '</div></div>';
                }
                echo '<div class="event-section">';
                echo '<h2 class="event-title">' . $row['title'] . ' - ' . date('F j, Y', strtotime($row['event_date'])) . '</h2>';
                echo '<div class="gallery-grid">';
                $current_event = $row['id'];
            }
            
            if($row['image_path']) {
                echo '<div class="gallery-item">';
                echo '<a href="../' . $row['image_path'] . '" data-lightbox="event-' . $row['id'] . '" data-title="' . $row['caption'] . '">';
                echo '<img src="../' . $row['image_path'] . '" alt="' . $row['caption'] . '">';
                echo '<div class="gallery-caption">' . $row['caption'] . '</div>';
                echo '</a>';
                echo '</div>';
            }
        }
        if($current_event !== null) {
            echo '</div></div>';
        }
        ?>
    </div>

    <footer>
        <div class="container">
        <p>&copy; <?php echo date('Y'); ?> Chokh Film Society - SUST. All rights reserved. Built by <a href="https://www.facebook.com/Idealtech.dev" target="_blank">Ideal Tech Ltd.</a></p>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script>
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
        });
    </script>
</body>
</html> 
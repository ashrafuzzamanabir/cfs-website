<?php
require_once __DIR__ . '/../config/db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Committee Members - Chokh Film Society</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .committee-container {
            padding: 2rem;
            margin-top: 60px;
        }
        .year-group {
            margin-bottom: 2rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 4px;
        }
        .year-group h2 {
            margin-bottom: 1rem;
            color: #333;
            border-bottom: 2px solid var(--accent-color);
            padding-bottom: 0.5rem;
        }
        .committee-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }
        .committee-member {
            background: white;
            padding: 1rem;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .committee-member img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 1rem;
            border: 3px solid var(--accent-color);
        }
        .committee-member h3 {
            margin: 0 0 0.5rem 0;
            color: var(--accent-color);
        }
        .committee-member p {
            margin: 0;
            color: #666;
        }
        /* Advisor Section Styles */
        .advisor-section {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .advisor-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 2rem;
            align-items: center;
        }
        .advisor-image {
            text-align: center;
        }
        .advisor-image img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid var(--accent-color);
        }
        .advisor-info h2 {
            color: var(--accent-color);
            margin-bottom: 1rem;
        }
        .advisor-info h3 {
            color: #333;
            margin-bottom: 0.5rem;
        }
        .advisor-message {
            font-style: italic;
            line-height: 1.8;
            color: #666;
            margin-top: 1rem;
        }
        @media (max-width: 768px) {
            .advisor-grid {
                grid-template-columns: 1fr;
                text-align: center;
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
            <li><a href="gallery.php">Gallery</a></li>
            <li><a href="committee.php">Committee</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>

    <div class="main-content">
        <div class="committee-container">
            <!-- Advisor Section -->
            <div class="advisor-section">
                <?php
                $sql = "SELECT * FROM advisors ORDER BY created_at DESC";
                $result = mysqli_query($conn, $sql);
                
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="advisor-grid">';
                    echo '<div class="advisor-image">';
                    if($row['image_path']) {
                        echo '<img src="../' . htmlspecialchars($row['image_path']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                    } else {
                        echo '<img src="../assets/images/default-avatar.png" alt="' . htmlspecialchars($row['name']) . '">';
                    }
                    echo '</div>';
                    echo '<div class="advisor-info">';
                    echo '<h2>Message from Our Advisor</h2>';
                    echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                    echo '<p>' . htmlspecialchars($row['designation']) . '</p>';
                    echo '<div class="advisor-message">';
                    echo '<p>' . nl2br(htmlspecialchars($row['message'])) . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>

            <h1>Committee Members</h1>
            <?php
            $sql = "SELECT * FROM committee_members ORDER BY year DESC, post ASC";
            $result = mysqli_query($conn, $sql);
            
            $current_year = null;
            while($row = mysqli_fetch_assoc($result)) {
                if($current_year !== $row['year']) {
                    if($current_year !== null) {
                        echo "</div></div>";
                    }
                    echo "<div class='year-group'>";
                    echo "<h2>Year " . $row['year'] . "</h2>";
                    echo "<div class='committee-grid'>";
                    $current_year = $row['year'];
                }
                echo "<div class='committee-member'>";
                if($row['image_path']) {
                    echo "<img src='../" . htmlspecialchars($row['image_path']) . "' alt='" . htmlspecialchars($row['name']) . "'>";
                } else {
                    echo "<img src='../assets/images/default-avatar.png' alt='" . htmlspecialchars($row['name']) . "'>";
                }
                echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                echo "<p>" . htmlspecialchars($row['post']) . "</p>";
                echo "</div>";
            }
            if($current_year !== null) {
                echo "</div></div>";
            }
            ?>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Chokh Film Society - SUST. All rights reserved. Built by <a href="https://www.facebook.com/Idealtech.dev" target="_blank">Ideal Tech Ltd.</a></p>
        </div>
    </footer>
</body>
</html> 
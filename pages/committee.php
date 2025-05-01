<?php
require_once '../config/db_config.php';
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
        .year-section {
            margin-bottom: 4rem;
        }
        .year-title {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--accent-color);
        }
        .members-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
        }
        .member-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .member-card:hover {
            transform: translateY(-5px);
        }
        .member-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        .member-info {
            padding: 1rem;
            text-align: center;
        }
        .member-name {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: var(--text-color);
        }
        .member-position {
            color: var(--accent-color);
            font-weight: 500;
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
            <li><a href="committee.php" class="active">Committee</a></li>
            <li><a href="gallery.php">Gallery</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>

    <div class="committee-container">
        <?php
        $sql = "SELECT DISTINCT year FROM committee_members ORDER BY year DESC";
        $years_result = mysqli_query($conn, $sql);
        
        while($year_row = mysqli_fetch_assoc($years_result)) {
            $year = $year_row['year'];
            echo '<div class="year-section">';
            echo '<h2 class="year-title">Committee ' . $year . '</h2>';
            echo '<div class="members-grid">';
            
            $members_sql = "SELECT * FROM committee_members WHERE year = ? ORDER BY position";
            $stmt = mysqli_prepare($conn, $members_sql);
            mysqli_stmt_bind_param($stmt, "i", $year);
            mysqli_stmt_execute($stmt);
            $members_result = mysqli_stmt_get_result($stmt);
            
            while($member = mysqli_fetch_assoc($members_result)) {
                echo '<div class="member-card">';
                if($member['image_path']) {
                    echo '<img src="../' . $member['image_path'] . '" alt="' . $member['name'] . '" class="member-image">';
                } else {
                    echo '<img src="../assets/images/default-avatar.jpg" alt="Default Avatar" class="member-image">';
                }
                echo '<div class="member-info">';
                echo '<h3 class="member-name">' . $member['name'] . '</h3>';
                echo '<p class="member-position">' . $member['position'] . '</p>';
                echo '</div>';
                echo '</div>';
            }
            
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Chokh Film Society - SUST. All rights reserved.</p>
        </div>
    </footer>
</body>
</html> 
<?php
require_once '../config/db_config.php';
session_start();

// Check if admin is logged in
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Handle committee member addition
if(isset($_POST['add_committee'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $post = mysqli_real_escape_string($conn, $_POST['post']);
    $year = $_POST['year'];
    
    // Handle image upload
    $image_path = null;
    if(isset($_FILES['member_image']) && $_FILES['member_image']['error'] == 0) {
        $target_dir = "../assets/uploads/committee/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $imageFileType = strtolower(pathinfo($_FILES["member_image"]["name"], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $new_filename;
        
        if(getimagesize($_FILES["member_image"]["tmp_name"]) !== false) {
            if (move_uploaded_file($_FILES["member_image"]["tmp_name"], $target_file)) {
                $image_path = "assets/uploads/committee/" . $new_filename;
            }
        }
    }
    
    $sql = "INSERT INTO committee_members (name, post, year, image_path) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssis", $name, $post, $year, $image_path);
    mysqli_stmt_execute($stmt);
}

// Handle committee member deletion
if(isset($_POST['delete_committee'])) {
    $id = $_POST['member_id'];
    $sql = "DELETE FROM committee_members WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Committee - Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .admin-container {
            padding: 2rem;
            margin-top: 60px;
        }
        .admin-section {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn {
            padding: 0.75rem 1.5rem;
            background: var(--accent-color);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-danger {
            background: #dc3545;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
        .year-group {
            margin-bottom: 2rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 4px;
        }
        .year-group h4 {
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
        }
        .committee-member img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 1rem;
            border: 3px solid var(--accent-color);
        }
        .navbar {
            background-color: var(--primary-color);
            padding: 0.5rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-inline: var(--content-padding);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-img {
            height: 40px;
            width: auto;
        }

        .logo h1 {
            margin: 0;
            font-size: 1.5rem;
            color: var(--secondary-color);
        }

        .nav-links {
            display: flex;
            gap: 0.5rem;
            list-style: none;
            margin: 0;
            padding: 0;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .nav-links li {
            position: relative;
        }

        .nav-links li a {
            color: var(--secondary-color);
            text-decoration: none;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            border-radius: 4px;
            display: block;
            font-size: 0.95rem;
            white-space: nowrap;
        }

        .nav-links li a:hover,
        .nav-links li a.active {
            color: var(--accent-color);
            background: rgba(255, 255, 255, 0.1);
        }

        .hamburger {
            display: none;
            background: none;
            border: none;
            color: var(--secondary-color);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
        }

        @media (max-width: 1024px) {
            .hamburger {
                display: block;
            }

            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: var(--primary-color);
                padding: 1rem;
                flex-direction: column;
                gap: 0.5rem;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }

            .nav-links.active {
                display: flex;
            }

            .nav-links li a {
                padding: 0.75rem 1rem;
                width: 100%;
                text-align: center;
            }

            .navbar {
                padding: 0.5rem var(--content-padding);
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="../assets/images/cfs.jpg" alt="CFS Logo" class="logo-img">
            <h1>Manage Committee</h1>
        </div>
        <button class="hamburger" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </button>
        <ul class="nav-links">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="manage_committee.php" class="active">Committee</a></li>
            <li><a href="../index.php">View Site</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="admin-container">
        <div class="admin-section">
            <h2>Add New Committee Member</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Member Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="post">Post</label>
                    <input type="text" id="post" name="post" required>
                </div>
                <div class="form-group">
                    <label for="year">Year</label>
                    <input type="number" id="year" name="year" min="2000" max="2099" required>
                </div>
                <div class="form-group">
                    <label for="member_image">Member Photo</label>
                    <input type="file" id="member_image" name="member_image" accept="image/*">
                </div>
                <button type="submit" name="add_committee" class="btn">Add Committee Member</button>
            </form>
        </div>

        <div class="admin-section">
            <h2>Current Committee Members</h2>
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
                    echo "<h4>Year " . $row['year'] . "</h4>";
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
                echo "<form method='POST' action='' style='margin-top: 1rem;'>";
                echo "<input type='hidden' name='member_id' value='" . $row['id'] . "'>";
                echo "<button type='submit' name='delete_committee' class='btn btn-danger'>Delete</button>";
                echo "</form>";
                echo "</div>";
            }
            if($current_year !== null) {
                echo "</div></div>";
            }
            ?>
        </div>
    </div>
    <script>
        function toggleMenu() {
            const navLinks = document.querySelector('.nav-links');
            navLinks.classList.toggle('active');
        }
    </script>
</body>
</html> 
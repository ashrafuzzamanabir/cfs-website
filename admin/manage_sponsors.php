<?php
require_once '../config/db_config.php';
session_start();

// Check if admin is logged in
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Handle sponsor addition
if(isset($_POST['add_sponsor'])) {
    $name = mysqli_real_escape_string($conn, $_POST['sponsor_name']);
    $website_url = mysqli_real_escape_string($conn, $_POST['website_url']);
    $description = mysqli_real_escape_string($conn, $_POST['sponsor_description']);
    
    // Handle logo upload
    $logo_path = null;
    if(isset($_FILES['sponsor_logo']) && $_FILES['sponsor_logo']['error'] == 0) {
        $target_dir = "../assets/uploads/sponsors/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $imageFileType = strtolower(pathinfo($_FILES["sponsor_logo"]["name"], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $new_filename;
        
        if(getimagesize($_FILES["sponsor_logo"]["tmp_name"]) !== false) {
            if (move_uploaded_file($_FILES["sponsor_logo"]["tmp_name"], $target_file)) {
                $logo_path = "assets/uploads/sponsors/" . $new_filename;
            }
        }
    }
    
    $sql = "INSERT INTO sponsors (name, logo_path, website_url, description) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $logo_path, $website_url, $description);
    mysqli_stmt_execute($stmt);
}

// Handle sponsor deletion
if(isset($_POST['delete_sponsor'])) {
    $id = $_POST['sponsor_id'];
    $sql = "DELETE FROM sponsors WHERE id = ?";
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
    <title>Manage Sponsors - Admin Dashboard</title>
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
        .form-group input, .form-group textarea {
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
        .sponsors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }
        .sponsor-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .sponsor-card img {
            max-width: 200px;
            max-height: 100px;
            object-fit: contain;
            margin-bottom: 1rem;
        }
        .sponsor-description {
            color: #666;
            margin: 1rem 0;
            flex-grow: 1;
        }
        .sponsor-website {
            color: var(--accent-color);
            text-decoration: none;
            margin-top: 1rem;
            display: inline-block;
        }
        .sponsor-website:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <h1>Admin Dashboard</h1>
        </div>
        <ul class="nav-links">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="../index.php">View Site</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="admin-container">
        <div class="admin-section">
            <h2>Add New Sponsor</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="sponsor_name">Sponsor Name</label>
                    <input type="text" id="sponsor_name" name="sponsor_name" required>
                </div>
                <div class="form-group">
                    <label for="website_url">Website URL</label>
                    <input type="url" id="website_url" name="website_url" required>
                </div>
                <div class="form-group">
                    <label for="sponsor_description">Description</label>
                    <textarea id="sponsor_description" name="sponsor_description" rows="2" required></textarea>
                </div>
                <div class="form-group">
                    <label for="sponsor_logo">Sponsor Logo</label>
                    <input type="file" id="sponsor_logo" name="sponsor_logo" accept="image/*" required>
                </div>
                <button type="submit" name="add_sponsor" class="btn">Add Sponsor</button>
            </form>
        </div>

        <div class="admin-section">
            <h2>Current Sponsors</h2>
            <div class="sponsors-grid">
                <?php
                $sql = "SELECT * FROM sponsors ORDER BY created_at DESC";
                $result = mysqli_query($conn, $sql);
                
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='sponsor-card'>";
                    if($row['logo_path']) {
                        echo "<img src='../" . htmlspecialchars($row['logo_path']) . "' alt='" . htmlspecialchars($row['name']) . "'>";
                    }
                    echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                    echo "<div class='sponsor-description'>";
                    echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                    echo "</div>";
                    if($row['website_url']) {
                        echo "<a href='" . htmlspecialchars($row['website_url']) . "' target='_blank' class='sponsor-website'>Visit Website</a>";
                    }
                    echo "<form method='POST' action='' style='margin-top: 1rem;'>";
                    echo "<input type='hidden' name='sponsor_id' value='" . $row['id'] . "'>";
                    echo "<button type='submit' name='delete_sponsor' class='btn btn-danger'>Delete</button>";
                    echo "</form>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html> 
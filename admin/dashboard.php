<?php
require_once '../config/db_config.php';
session_start();

// Check if admin is logged in
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Handle file upload
if(isset($_POST['upload'])) {
    $event_id = $_POST['event_id'];
    $caption = mysqli_real_escape_string($conn, $_POST['caption']);
    
    $target_dir = "../assets/uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // Check if image file is actual image
    if(getimagesize($_FILES["image"]["tmp_name"]) !== false) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = "assets/uploads/" . basename($_FILES["image"]["name"]);
            $sql = "INSERT INTO gallery (event_id, image_path, caption) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "iss", $event_id, $image_path, $caption);
            mysqli_stmt_execute($stmt);
        }
    }
}

// Handle new event creation
if(isset($_POST['create_event'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $event_date = $_POST['event_date'];
    
    $sql = "INSERT INTO events (title, description, event_date) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $title, $description, $event_date);
    mysqli_stmt_execute($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Chokh Film Society</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .dashboard {
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
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <h1>Admin Dashboard</h1>
        </div>
        <ul class="nav-links">
            <li><a href="../index.php">View Site</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="dashboard">
        <div class="admin-section">
            <h2>Create New Event</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="title">Event Title</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="event_date">Event Date</label>
                    <input type="date" id="event_date" name="event_date" required>
                </div>
                <button type="submit" name="create_event" class="btn">Create Event</button>
            </form>
        </div>

        <div class="admin-section">
            <h2>Upload Image to Gallery</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="event_id">Select Event</label>
                    <select id="event_id" name="event_id" required>
                        <?php
                        $sql = "SELECT id, title FROM events ORDER BY event_date DESC";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['id'] . "'>" . $row['title'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image">Select Image</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label for="caption">Image Caption</label>
                    <input type="text" id="caption" name="caption" required>
                </div>
                <button type="submit" name="upload" class="btn">Upload Image</button>
            </form>
        </div>
    </div>
</body>
</html> 
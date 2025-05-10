<?php
require_once '../config/db_config.php';
session_start();

// Check if admin is logged in
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Handle advisor addition
if(isset($_POST['add_advisor'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $designation = mysqli_real_escape_string($conn, $_POST['designation']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Handle image upload
    $image_path = null;
    if(isset($_FILES['advisor_image']) && $_FILES['advisor_image']['error'] == 0) {
        $target_dir = "../assets/uploads/advisors/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $imageFileType = strtolower(pathinfo($_FILES["advisor_image"]["name"], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $new_filename;
        
        if(getimagesize($_FILES["advisor_image"]["tmp_name"]) !== false) {
            if (move_uploaded_file($_FILES["advisor_image"]["tmp_name"], $target_file)) {
                $image_path = "assets/uploads/advisors/" . $new_filename;
            }
        }
    }
    
    $sql = "INSERT INTO advisors (name, designation, image_path, message) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $designation, $image_path, $message);
    mysqli_stmt_execute($stmt);
}

// Handle advisor deletion
if(isset($_POST['delete_advisor'])) {
    $id = $_POST['advisor_id'];
    $sql = "DELETE FROM advisors WHERE id = ?";
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
    <title>Manage Advisors - Admin Dashboard</title>
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
        .advisor-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }
        .advisor-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }
        .advisor-card img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 1rem;
            border: 3px solid var(--accent-color);
        }
        .advisor-message {
            font-style: italic;
            color: #666;
            margin: 1rem 0;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 4px;
            border-left: 4px solid var(--accent-color);
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
            <h2>Add New Advisor</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Advisor Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="designation">Designation</label>
                    <input type="text" id="designation" name="designation" required>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="advisor_image">Advisor Photo</label>
                    <input type="file" id="advisor_image" name="advisor_image" accept="image/*" required>
                </div>
                <button type="submit" name="add_advisor" class="btn">Add Advisor</button>
            </form>
        </div>

        <div class="admin-section">
            <h2>Current Advisors</h2>
            <div class="advisor-grid">
                <?php
                $sql = "SELECT * FROM advisors ORDER BY created_at DESC";
                $result = mysqli_query($conn, $sql);
                
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='advisor-card'>";
                    if($row['image_path']) {
                        echo "<img src='../" . htmlspecialchars($row['image_path']) . "' alt='" . htmlspecialchars($row['name']) . "'>";
                    } else {
                        echo "<img src='../assets/images/default-avatar.png' alt='" . htmlspecialchars($row['name']) . "'>";
                    }
                    echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                    echo "<p>" . htmlspecialchars($row['designation']) . "</p>";
                    echo "<div class='advisor-message'>";
                    echo "<p>" . nl2br(htmlspecialchars($row['message'])) . "</p>";
                    echo "</div>";
                    echo "<form method='POST' action=''>";
                    echo "<input type='hidden' name='advisor_id' value='" . $row['id'] . "'>";
                    echo "<button type='submit' name='delete_advisor' class='btn btn-danger'>Delete</button>";
                    echo "</form>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html> 
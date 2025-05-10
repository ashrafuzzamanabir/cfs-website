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
        
        // Check if image file is actual image
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
        .committee-member {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem;
            margin-bottom: 0.5rem;
            background: white;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .committee-member p {
            margin: 0;
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

        <div class="admin-section">
            <h2>Manage Committee Members</h2>
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

            <h3>Current Committee Members</h3>
            <?php
            $sql = "SELECT * FROM committee_members ORDER BY year DESC, post ASC";
            $result = mysqli_query($conn, $sql);
            
            $current_year = null;
            while($row = mysqli_fetch_assoc($result)) {
                if($current_year !== $row['year']) {
                    if($current_year !== null) {
                        echo "</div>";
                    }
                    echo "<div class='year-group'>";
                    echo "<h4>Year " . $row['year'] . "</h4>";
                    $current_year = $row['year'];
                }
                echo "<div class='committee-member'>";
                if($row['image_path']) {
                    echo "<img src='../" . htmlspecialchars($row['image_path']) . "' alt='" . htmlspecialchars($row['name']) . "' style='width: 100px; height: 100px; object-fit: cover; border-radius: 50%; margin-right: 1rem;'>";
                }
                echo "<div style='flex-grow: 1;'>";
                echo "<p><strong>" . htmlspecialchars($row['name']) . "</strong> - " . htmlspecialchars($row['post']) . "</p>";
                echo "</div>";
                echo "<form method='POST' action='' style='display:inline;'>";
                echo "<input type='hidden' name='member_id' value='" . $row['id'] . "'>";
                echo "<button type='submit' name='delete_committee' class='btn btn-danger'>Delete</button>";
                echo "</form>";
                echo "</div>";
            }
            if($current_year !== null) {
                echo "</div>";
            }
            ?>
        </div>

        <div class="admin-section">
            <h2>Manage Advisors</h2>
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

            <h3>Current Advisors</h3>
            <?php
            $sql = "SELECT * FROM advisors ORDER BY created_at DESC";
            $result = mysqli_query($conn, $sql);
            
            while($row = mysqli_fetch_assoc($result)) {
                echo "<div class='committee-member'>";
                if($row['image_path']) {
                    echo "<img src='../" . htmlspecialchars($row['image_path']) . "' alt='" . htmlspecialchars($row['name']) . "' style='width: 100px; height: 100px; object-fit: cover; border-radius: 50%; margin-right: 1rem;'>";
                }
                echo "<div style='flex-grow: 1;'>";
                echo "<p><strong>" . htmlspecialchars($row['name']) . "</strong> - " . htmlspecialchars($row['designation']) . "</p>";
                echo "<p><em>" . htmlspecialchars($row['message']) . "</em></p>";
                echo "</div>";
                echo "<form method='POST' action='' style='display:inline;'>";
                echo "<input type='hidden' name='advisor_id' value='" . $row['id'] . "'>";
                echo "<button type='submit' name='delete_advisor' class='btn btn-danger'>Delete</button>";
                echo "</form>";
                echo "</div>";
            }
            ?>
        </div>

        <div class="admin-section">
            <h2>Manage Sponsors</h2>
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

            <h3>Current Sponsors</h3>
            <div style="display: flex; flex-wrap: wrap; gap: 1rem;">
            <?php
            $sql = "SELECT * FROM sponsors ORDER BY created_at DESC";
            $result = mysqli_query($conn, $sql);
            
            while($row = mysqli_fetch_assoc($result)) {
                echo "<div style='background: white; padding: 1rem; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); flex: 1 1 300px;'>";
                if($row['logo_path']) {
                    echo "<img src='../" . htmlspecialchars($row['logo_path']) . "' alt='" . htmlspecialchars($row['name']) . "' style='max-width: 150px; max-height: 100px; object-fit: contain; margin-bottom: 0.5rem;'>";
                }
                echo "<h4>" . htmlspecialchars($row['name']) . "</h4>";
                echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                if($row['website_url']) {
                    echo "<a href='" . htmlspecialchars($row['website_url']) . "' target='_blank' style='color: var(--accent-color);'>Visit Website</a>";
                }
                echo "<form method='POST' action='' style='margin-top: 0.5rem;'>";
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
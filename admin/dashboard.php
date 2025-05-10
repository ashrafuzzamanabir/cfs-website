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

// Handle event deletion
if(isset($_POST['delete_event'])) {
    $id = $_POST['event_id'];
    $sql = "DELETE FROM events WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

// Handle gallery image deletion
if(isset($_POST['delete_image'])) {
    $id = $_POST['image_id'];
    $sql = "DELETE FROM gallery WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

// Handle event update
if(isset($_POST['update_event'])) {
    $id = $_POST['event_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $event_date = $_POST['event_date'];
    
    $sql = "UPDATE events SET title = ?, description = ?, event_date = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $title, $description, $event_date, $id);
    mysqli_stmt_execute($stmt);
}

// Handle gallery image update
if(isset($_POST['update_image'])) {
    $id = $_POST['image_id'];
    $caption = mysqli_real_escape_string($conn, $_POST['caption']);
    $event_id = $_POST['event_id'];
    
    $sql = "UPDATE gallery SET caption = ?, event_id = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sii", $caption, $event_id, $id);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn i {
            margin-right: 0.5rem;
        }
        .btn-danger {
            background: #dc3545;
        }
        .btn-warning {
            background: #ffc107;
            color: #000;
        }
        .quick-links-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }
        .events-grid, .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        .event-card, .gallery-card {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .gallery-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 1rem;
        }
        .card-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }
        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            max-width: 500px;
            margin: 2rem auto;
            position: relative;
        }
        .close {
            position: absolute;
            right: 1rem;
            top: 1rem;
            font-size: 1.5rem;
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
            <h2>Quick Links</h2>
            <div class="quick-links-grid">
                <a href="manage_committee.php" class="btn">
                    <i class="fas fa-users"></i> Manage Committee
                </a>
                <a href="manage_advisors.php" class="btn">
                    <i class="fas fa-user-tie"></i> Manage Advisors
                </a>
                <a href="manage_sponsors.php" class="btn">
                    <i class="fas fa-handshake"></i> Manage Sponsors
                </a>
            </div>
        </div>

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

            <h3>Current Events</h3>
            <div class="events-grid">
                <?php
                $sql = "SELECT * FROM events ORDER BY event_date DESC";
                $result = mysqli_query($conn, $sql);
                
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='event-card'>";
                    echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                    echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                    echo "<p><strong>Date:</strong> " . date('F j, Y', strtotime($row['event_date'])) . "</p>";
                    echo "<div class='card-actions'>";
                    echo "<button onclick='editEvent(" . $row['id'] . ", \"" . htmlspecialchars($row['title']) . "\", \"" . htmlspecialchars($row['description']) . "\", \"" . $row['event_date'] . "\")' class='btn btn-warning'><i class='fas fa-edit'></i> Edit</button>";
                    echo "<form method='POST' action='' style='display:inline;'>";
                    echo "<input type='hidden' name='event_id' value='" . $row['id'] . "'>";
                    echo "<button type='submit' name='delete_event' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this event?\")'><i class='fas fa-trash'></i> Delete</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </div>
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

            <h3>Gallery Images</h3>
            <div class="gallery-grid">
                <?php
                $sql = "SELECT g.*, e.title as event_title FROM gallery g 
                        LEFT JOIN events e ON g.event_id = e.id 
                        ORDER BY g.created_at DESC";
                $result = mysqli_query($conn, $sql);
                
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='gallery-card'>";
                    echo "<img src='../" . htmlspecialchars($row['image_path']) . "' alt='" . htmlspecialchars($row['caption']) . "'>";
                    echo "<p><strong>Caption:</strong> " . htmlspecialchars($row['caption']) . "</p>";
                    echo "<p><strong>Event:</strong> " . htmlspecialchars($row['event_title']) . "</p>";
                    echo "<div class='card-actions'>";
                    echo "<button onclick='editImage(" . $row['id'] . ", \"" . htmlspecialchars($row['caption']) . "\", " . $row['event_id'] . ")' class='btn btn-warning'><i class='fas fa-edit'></i> Edit</button>";
                    echo "<form method='POST' action='' style='display:inline;'>";
                    echo "<input type='hidden' name='image_id' value='" . $row['id'] . "'>";
                    echo "<button type='submit' name='delete_image' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this image?\")'><i class='fas fa-trash'></i> Delete</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Edit Event Modal -->
    <div id="editEventModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editEventModal')">&times;</span>
            <h2>Edit Event</h2>
            <form method="POST" action="">
                <input type="hidden" name="event_id" id="edit_event_id">
                <div class="form-group">
                    <label for="edit_title">Event Title</label>
                    <input type="text" id="edit_title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="edit_description">Description</label>
                    <textarea id="edit_description" name="description" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="edit_event_date">Event Date</label>
                    <input type="date" id="edit_event_date" name="event_date" required>
                </div>
                <button type="submit" name="update_event" class="btn">Update Event</button>
            </form>
        </div>
    </div>

    <!-- Edit Image Modal -->
    <div id="editImageModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editImageModal')">&times;</span>
            <h2>Edit Image</h2>
            <form method="POST" action="">
                <input type="hidden" name="image_id" id="edit_image_id">
                <div class="form-group">
                    <label for="edit_caption">Caption</label>
                    <input type="text" id="edit_caption" name="caption" required>
                </div>
                <div class="form-group">
                    <label for="edit_image_event_id">Event</label>
                    <select id="edit_image_event_id" name="event_id" required>
                        <?php
                        $sql = "SELECT id, title FROM events ORDER BY event_date DESC";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['id'] . "'>" . $row['title'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" name="update_image" class="btn">Update Image</button>
            </form>
        </div>
    </div>

    <script>
        function editEvent(id, title, description, date) {
            document.getElementById('edit_event_id').value = id;
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_description').value = description;
            document.getElementById('edit_event_date').value = date;
            document.getElementById('editEventModal').style.display = 'block';
        }

        function editImage(id, caption, eventId) {
            document.getElementById('edit_image_id').value = id;
            document.getElementById('edit_caption').value = caption;
            document.getElementById('edit_image_event_id').value = eventId;
            document.getElementById('editImageModal').style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.className === 'modal') {
                event.target.style.display = 'none';
            }
        }
    </script>
</body>
</html> 
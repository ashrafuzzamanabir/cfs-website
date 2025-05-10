<?php
require_once '../config/db_config.php';
session_start();

// Check if admin is logged in
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Handle contact info update
if(isset($_POST['update_contact'])) {
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $facebook_link = mysqli_real_escape_string($conn, $_POST['facebook_link']);
    $instagram_link = mysqli_real_escape_string($conn, $_POST['instagram_link']);
    $map_embed_url = mysqli_real_escape_string($conn, $_POST['map_embed_url']);
    
    $sql = "UPDATE contact_info SET 
            location = ?, 
            email = ?, 
            phone = ?, 
            facebook_link = ?, 
            instagram_link = ?, 
            map_embed_url = ? 
            WHERE id = 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $location, $email, $phone, $facebook_link, $instagram_link, $map_embed_url);
    
    if(mysqli_stmt_execute($stmt)) {
        $_SESSION['success_message'] = "Contact information updated successfully!";
    } else {
        $_SESSION['error_message'] = "Error updating contact information: " . mysqli_error($conn);
    }
}

// Get current contact information
$sql = "SELECT * FROM contact_info WHERE id = 1";
$result = mysqli_query($conn, $sql);
$contact_info = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Contact Information - Admin Dashboard</title>
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
        .form-group textarea {
            min-height: 100px;
        }
        .btn {
            padding: 0.75rem 1.5rem;
            background: var(--accent-color);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .preview-section {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #ddd;
        }
        .contact-item {
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
        }
        .contact-item i {
            margin-right: 1rem;
            color: var(--accent-color);
        }
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
        <?php if(isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?php 
                echo $_SESSION['success_message'];
                unset($_SESSION['success_message']);
                ?>
            </div>
        <?php endif; ?>

        <?php if(isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php 
                echo $_SESSION['error_message'];
                unset($_SESSION['error_message']);
                ?>
            </div>
        <?php endif; ?>

        <div class="admin-section">
            <h2>Manage Contact Information</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="location">Location</label>
                    <textarea id="location" name="location" required><?php echo htmlspecialchars($contact_info['location'] ?? ''); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($contact_info['email'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($contact_info['phone'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="facebook_link">Facebook Link</label>
                    <input type="url" id="facebook_link" name="facebook_link" value="<?php echo htmlspecialchars($contact_info['facebook_link'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="instagram_link">Instagram Link</label>
                    <input type="url" id="instagram_link" name="instagram_link" value="<?php echo htmlspecialchars($contact_info['instagram_link'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="map_embed_url">Google Maps Embed URL</label>
                    <input type="url" id="map_embed_url" name="map_embed_url" value="<?php echo htmlspecialchars($contact_info['map_embed_url'] ?? ''); ?>" required>
                </div>
                <button type="submit" name="update_contact" class="btn">Update Contact Information</button>
            </form>

            <div class="preview-section">
                <h3>Preview</h3>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h3>Location</h3>
                            <p><?php echo nl2br(htmlspecialchars($contact_info['location'] ?? '')); ?></p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h3>Email</h3>
                            <p><a href="mailto:<?php echo htmlspecialchars($contact_info['email'] ?? ''); ?>"><?php echo htmlspecialchars($contact_info['email'] ?? ''); ?></a></p>
                        </div>
                    </div>
                    <?php if (!empty($contact_info['phone'])): ?>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h3>Phone</h3>
                            <p><a href="tel:<?php echo htmlspecialchars($contact_info['phone'] ?? ''); ?>"><?php echo htmlspecialchars($contact_info['phone'] ?? ''); ?></a></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($contact_info['facebook_link'])): ?>
                    <div class="contact-item">
                        <i class="fab fa-facebook"></i>
                        <div>
                            <h3>Facebook</h3>
                            <p><a href="<?php echo htmlspecialchars($contact_info['facebook_link'] ?? ''); ?>" target="_blank">facebook.com/cfssust</a></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($contact_info['instagram_link'])): ?>
                    <div class="contact-item">
                        <i class="fab fa-instagram"></i>
                        <div>
                            <h3>Instagram</h3>
                            <p><a href="<?php echo htmlspecialchars($contact_info['instagram_link'] ?? ''); ?>" target="_blank">instagram.com/chokhfilmsociety</a></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 
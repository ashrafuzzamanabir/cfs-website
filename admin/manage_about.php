<?php
require_once '../config/db_config.php';
session_start();

// Check if admin is logged in
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Handle about page content update
if(isset($_POST['update_about'])) {
    $about_text = mysqli_real_escape_string($conn, $_POST['about_text']);
    $facebook_link = mysqli_real_escape_string($conn, $_POST['facebook_link']);
    $instagram_link = mysqli_real_escape_string($conn, $_POST['instagram_link']);
    $email_address = mysqli_real_escape_string($conn, $_POST['email_address']);
    
    $sql = "UPDATE about_page SET 
            about_text = ?, 
            facebook_link = ?, 
            instagram_link = ?, 
            email_address = ? 
            WHERE id = 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $about_text, $facebook_link, $instagram_link, $email_address);
    
    if(mysqli_stmt_execute($stmt)) {
        $_SESSION['success_message'] = "About page content updated successfully!";
    } else {
        $_SESSION['error_message'] = "Error updating content: " . mysqli_error($conn);
    }
}

// Handle delete
if(isset($_POST['delete_about'])) {
    $sql = "DELETE FROM about_page WHERE id = 1";
    if(mysqli_query($conn, $sql)) {
        $_SESSION['success_message'] = "Content deleted successfully!";
    } else {
        $_SESSION['error_message'] = "Error deleting content: " . mysqli_error($conn);
    }
}

// Get current about page content
$sql = "SELECT * FROM about_page WHERE id = 1";
$result = mysqli_query($conn, $sql);
$about_content = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage About Page - Admin Dashboard</title>
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
            min-height: 200px;
        }
        .btn {
            padding: 0.75rem 1.5rem;
            background: var(--accent-color);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 1rem;
        }
        .btn-danger {
            background: #dc3545;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        .preview-section {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #ddd;
        }
        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        .social-link {
            display: inline-block;
            background: var(--accent-color);
            color: white;
            padding: 1rem 2rem;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .social-link:hover {
            background-color: #c4000f;
        }
        .social-link i {
            margin-right: 0.5rem;
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
            <h1>Manage About</h1>
        </div>
        <button class="hamburger" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </button>
        <ul class="nav-links">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="manage_about.php" class="active">About</a></li>
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
            <h2>Manage About Page Content</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="about_text">About Text</label>
                    <textarea id="about_text" name="about_text" required><?php echo htmlspecialchars($about_content['about_text'] ?? ''); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="facebook_link">Facebook Link</label>
                    <input type="url" id="facebook_link" name="facebook_link" value="<?php echo htmlspecialchars($about_content['facebook_link'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="instagram_link">Instagram Link</label>
                    <input type="url" id="instagram_link" name="instagram_link" value="<?php echo htmlspecialchars($about_content['instagram_link'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email_address">Email Address</label>
                    <input type="email" id="email_address" name="email_address" value="<?php echo htmlspecialchars($about_content['email_address'] ?? ''); ?>" required>
                </div>
                <div class="button-group">
                    <button type="submit" name="update_about" class="btn">Update About Page</button>
                    <button type="submit" name="delete_about" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this content?')">Delete Content</button>
                </div>
            </form>

            <div class="preview-section">
                <h3>Preview</h3>
                <div class="about-text">
                    <?php echo nl2br(htmlspecialchars($about_content['about_text'] ?? '')); ?>
                </div>
                <div class="social-links">
                    <?php if (!empty($about_content['facebook_link'])): ?>
                        <a href="<?php echo htmlspecialchars($about_content['facebook_link']); ?>" target="_blank" class="social-link">
                            <i class="fab fa-facebook"></i> Facebook
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($about_content['instagram_link'])): ?>
                        <a href="<?php echo htmlspecialchars($about_content['instagram_link']); ?>" target="_blank" class="social-link">
                            <i class="fab fa-instagram"></i> Instagram
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($about_content['email_address'])): ?>
                        <a href="mailto:<?php echo htmlspecialchars($about_content['email_address']); ?>" class="social-link">
                            <i class="fas fa-envelope"></i> Email Us
                        </a>
                    <?php endif; ?>
                </div>
            </div>
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
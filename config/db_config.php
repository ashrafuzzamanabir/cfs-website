<?php
define('DB_SERVER', '127.0.0.1:3307');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'cfs_db');

// Attempt to connect to MySQL database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Create about_page table if it doesn't exist
$create_table_sql = "CREATE TABLE IF NOT EXISTS about_page (
    id INT PRIMARY KEY AUTO_INCREMENT,
    about_text TEXT,
    facebook_link VARCHAR(255),
    instagram_link VARCHAR(255),
    email_address VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if (!mysqli_query($conn, $create_table_sql)) {
    die("Error creating table: " . mysqli_error($conn));
}

// Insert default content if table is empty
$check_content = "SELECT COUNT(*) as count FROM about_page";
$result = mysqli_query($conn, $check_content);
$row = mysqli_fetch_assoc($result);

if ($row['count'] == 0) {
    $insert_default = "INSERT INTO about_page (about_text, facebook_link, instagram_link, email_address) 
                      VALUES ('Welcome to Chokh Film Society! We are dedicated to promoting film culture at SUST since 2010.', 
                             'https://facebook.com/chokhfilmsociety', 
                             'https://instagram.com/chokhfilmsociety', 
                             'cfs@sust.edu')";
    mysqli_query($conn, $insert_default);
}

// Create contact_info table if it doesn't exist
$create_contact_table = "CREATE TABLE IF NOT EXISTS contact_info (
    id INT PRIMARY KEY AUTO_INCREMENT,
    location TEXT,
    email VARCHAR(255),
    phone VARCHAR(50),
    facebook_link VARCHAR(255),
    instagram_link VARCHAR(255),
    map_embed_url TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if (!mysqli_query($conn, $create_contact_table)) {
    die("Error creating contact_info table: " . mysqli_error($conn));
}

// Insert default contact info if table is empty
$check_contact = "SELECT COUNT(*) as count FROM contact_info";
$result = mysqli_query($conn, $check_contact);
$row = mysqli_fetch_assoc($result);

if ($row['count'] == 0) {
    $insert_contact = "INSERT INTO contact_info (location, email, phone, facebook_link, instagram_link, map_embed_url) 
                      VALUES ('Shahjalal University of Science and Technology\nSylhet 3114, Bangladesh',
                             'cfs@sust.edu',
                             '+880 1234567890',
                             'https://www.facebook.com/cfssust',
                             'https://instagram.com/chokhfilmsociety',
                             'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3618.8274566013213!2d91.83075931500685!3d24.91745498400939!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3750552bc91107d1%3A0x6e2a32d2bb0e5096!2sShahjalal%20University%20of%20Science%20and%20Technology!5e0!3m2!1sen!2sbd!4v1625147000000!5m2!1sen!2sbd')";
    mysqli_query($conn, $insert_contact);
}
?>
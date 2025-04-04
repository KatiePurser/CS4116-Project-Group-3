<?php
include_once __DIR__ . '/../../utilities/databaseHandler.php';

if (!isset($_GET['id'])) {
    die("User ID not specified.");
}

$user_id = intval($_GET['id']);

// Fetch image data from the database
$query = "SELECT profile_picture FROM users WHERE id = $user_id";
$userData = DatabaseHandler::make_select_query($query);

if ($userData && count($userData) > 0 && !empty($userData[0]['profile_picture'])) {
    $imageData = $userData[0]['profile_picture'];

    // Set the appropriate content type header
    header("Content-Type: image/png"); // Change to "image/jpeg" if we are using JPEG images
    echo $imageData;
    exit;
} else {
    // If no image is found, return a placeholder
    header("Content-Type: image/png");
    readfile("/CS4116-Project-Group-3/the_artist_harbour/public/images/user_icon.svg"); // Make sure this file exists
    exit;
}
?>

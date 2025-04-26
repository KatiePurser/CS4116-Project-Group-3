<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once __DIR__ . '/../../utilities/databaseHandler.php';

if (!isset($_GET['id'])) {
    die("Service ID not specified.");
}

$service_id = intval($_GET['id']);

// Fetch service image from the database
$query = "SELECT image FROM services WHERE id = $service_id";
$serviceData = DatabaseHandler::make_select_query($query);

if ($serviceData && count($serviceData) > 0 && !empty($serviceData[0]['image'])) {
    $imageData = $serviceData[0]['image'];
 
    // Set correct Content-Type header
    header("Content-Type: image/png"); 
    
    // Ensure the correct Content-Length header is set
    header("Content-Length: " . strlen($imageData)); 
    // Output the image data 
    echo $imageData;
    exit;
    
} else {
    // Return default service image if no image is found
    header("Content-Type: image/png");
    readfile(__DIR__ . "/../../public/images/default.png");
    exit;
}
?>

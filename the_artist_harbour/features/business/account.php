<?php
session_start();
include_once __DIR__ . '/../../utilities/DatabaseHandler.php';
include_once __DIR__ . '/../../utilities/ImageHandler.php';
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /CS4116-Project-Group-3/the_artist_harbour/features/registration-login/login.php");
    exit();
}

// Check if the user is a business account
if ($_SESSION['user_type'] !== 'business') {
    exit();
}

// Assign the user ID from the session
$user_id = $_SESSION["user_id"];


// Fetch the business data
$query = "SELECT * FROM businesses WHERE user_id = $user_id";
$businessData = DatabaseHandler::make_select_query($query);

// Check if a business is found
if (empty($businessData)) {
    die("No business found for this user. Please ensure your business profile is set up.");
}

// Use null coalescing operator to assign values 
$business_id = $businessData[0]['id'];
$business_name = $businessData[0]['display_name'] ?? "Please fill in Business name";
$business_description = $businessData[0]['description'] ?? "Please fill in Business bio..";
$instagram = $businessData[0]['instagram'] ?? "#";
$facebook = $businessData[0]['facebook'] ?? "#";
$tiktok = $businessData[0]['tiktok'] ?? "#";
$pinterest = $businessData[0]['pinterest'] ?? "#";
$website = $businessData[0]['website'] ?? "#";

// Handle form submission for updating business details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data for business details
    if ($business_id && isset($_POST['business_name'], $_POST['business_description'])) {
        $business_name = filter_input(INPUT_POST, 'business_name', FILTER_SANITIZE_STRING);
        $business_description = filter_input(INPUT_POST, 'business_description', FILTER_SANITIZE_STRING);

        $query = sprintf(
            "UPDATE businesses SET display_name = '%s', description = '%s' WHERE id = %d",
            addslashes($business_name),
            addslashes($business_description),
            $business_id
        );
        $result = DatabaseHandler::make_modify_query($query);

        if ($result !== null) {
            $_SESSION['message'] = 'Business details updated successfully!';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Error updating business details.';
            $_SESSION['message_type'] = 'danger';
        }
    }

    // Collect form data for social media links
    if (isset($_POST['instagram']) || isset($_POST['facebook']) || isset($_POST['tiktok']) || isset($_POST['pinterest']) || isset($_POST['website'])) {
        $instagram = filter_input(INPUT_POST, 'instagram', FILTER_SANITIZE_URL);
        $facebook = filter_input(INPUT_POST, 'facebook', FILTER_SANITIZE_URL);
        $tiktok = filter_input(INPUT_POST, 'tiktok', FILTER_SANITIZE_URL);
        $pinterest = filter_input(INPUT_POST, 'pinterest', FILTER_SANITIZE_URL);
        $website = filter_input(INPUT_POST, 'website', FILTER_SANITIZE_URL);

        // Create update query for social media links
        $query = sprintf(
            "UPDATE businesses SET instagram='%s', facebook='%s', tiktok='%s', pinterest='%s', website='%s' WHERE id='%d'",
            $instagram,
            $facebook,
            $tiktok,
            $pinterest,
            $website,
            $business_id
        );
        $result = DatabaseHandler::make_modify_query($query);

        if ($result !== null) {
            $_SESSION['message'] = 'Social media links updated successfully!';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Error updating social media links.';
            $_SESSION['message_type'] = 'danger';
        }
    }

    // Check if we're editing an existing service
    if (isset($_POST['service_id']) && is_numeric($_POST['service_id'])) {
        $service_id = intval($_POST['service_id']);  // This should match the service you're updating

        // Sanitize and validate input
        $service_name = filter_input(INPUT_POST, 'service_name', FILTER_SANITIZE_STRING);
        $service_description = filter_input(INPUT_POST, 'service_description', FILTER_SANITIZE_STRING);

        // Process tags
        $service_tags = [];
        if (isset($_POST['tags']) && is_array($_POST['tags'])) {
            $service_tags = $_POST['tags'];
        }
        $service_tags = array_map('trim', $service_tags);
        $service_tags = array_unique($service_tags);
        $service_tags_str = implode(',', $service_tags);

        // Check if service is negotiable
        $negotiable = isset($_POST['service_negotiable']) ? 1 : 0;
        $min_price = $negotiable ? filter_input(INPUT_POST, 'service_min_price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : null;
        $max_price = filter_input(INPUT_POST, 'service_max_price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        // Update the service in the database
        $query = "UPDATE services SET 
                    name = '" . addslashes($service_name) . "', 
                    description = '" . addslashes($service_description) . "',
                    tags = '" . addslashes($service_tags_str) . "',
                    min_price = " . ($min_price !== null ? $min_price : "NULL") . ",
                    max_price = " . ($max_price !== null ? $max_price : "NULL") . "
                  WHERE id = {$service_id} AND business_id = {$business_id}";

        $result = DatabaseHandler::make_modify_query($query);

        // Handle image upload separately
        if (isset($_FILES['service_image']) && $_FILES['service_image']['error'] === UPLOAD_ERR_OK) {
            $image_uploaded = ImageHandler::uploadAndStoreImage('service_image', 'services', 'image', 'id', $service_id);
        }

        if ($result !== null) {
            $_SESSION['message'] = 'Service updated successfully!';
            $_SESSION['message_type'] = 'success';
            header("Location: account.php");
            exit();
        } else {
            $_SESSION['message'] = 'Error updating service. Please try again.';
            $_SESSION['message_type'] = 'danger';
            header("Location: account.php");
            exit();
        }
    }
    // Otherwise, check if we're adding a new service
    else if (isset($_POST['service_name'])) {
        // Collect form data for the new service
        $service_name = filter_input(INPUT_POST, 'service_name', FILTER_SANITIZE_STRING);
        $service_description = filter_input(INPUT_POST, 'service_description', FILTER_SANITIZE_STRING);
        // Check if negotiable is true or false
        $negotiable = isset($_POST['service_negotiable']) ? 1 : 0;

        // Get min_price and max_price based on negotiable
        $min_price = null;
        if ($negotiable && isset($_POST['service_min_price']) && !empty($_POST['service_min_price'])) {
            $min_price = filter_input(INPUT_POST, 'service_min_price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        }

        $max_price = filter_input(INPUT_POST, 'service_max_price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        // Validate prices based on negotiable flag
        if ($negotiable && (!$min_price || !$max_price)) {
            $_SESSION['message'] = 'Both min and max prices are required when negotiable is true.';
            $_SESSION['message_type'] = 'warning';
            header("Location: account.php");
            exit();
        } elseif (!$negotiable && !$max_price) {
            $_SESSION['message'] = 'Max price is required when negotiable is false.';
            $_SESSION['message_type'] = 'warning';
            header("Location: account.php");
            exit();
        }

        $service_tags = isset($_POST['tags']) ? $_POST['tags'] : [];
        $service_tags = array_map('trim', $service_tags);
        $service_tags = array_unique($service_tags);
        $service_tags_str = implode(',', $service_tags); // Convert array to string for storage

        // First insert the service without the image to get an ID
        $insert_query = "INSERT INTO services (business_id, name, description, tags, min_price, max_price, created_at) 
        VALUES (
            $business_id, 
            '" . addslashes($service_name) . "', 
            '" . addslashes($service_description) . "', 
            '" . addslashes($service_tags_str) . "',
            " . ($min_price !== null ? $min_price : "NULL") . ", 
            " . ($max_price !== null ? $max_price : "NULL") . ", 
            NOW()
        )";

        $result = DatabaseHandler::make_modify_query($insert_query);

        if ($result !== null) {
            // Get the last inserted ID
            $query = "SELECT MAX(id) as last_id FROM services WHERE business_id = $business_id";
            $last_id_result = DatabaseHandler::make_select_query($query);
            $service_id = $last_id_result[0]['last_id'];

            // Now handle the image upload with the correct service ID
            if (isset($_FILES['service_image']) && $_FILES['service_image']['error'] === UPLOAD_ERR_OK) {
                $image_uploaded = ImageHandler::uploadAndStoreImage('service_image', 'services', 'image', 'id', $service_id);
            }

            $_SESSION['message'] = 'New service added successfully!';
            $_SESSION['message_type'] = 'success';
            header("Location: account.php");
            exit();
        } else {
            $_SESSION['message'] = 'Error adding service. Please try again.';
            $_SESSION['message_type'] = 'danger';
            header("Location: account.php");
            exit();
        }
    }
}

// Fetch all services related to this business
$query = "SELECT * FROM services WHERE business_id = $business_id";
$services = DatabaseHandler::make_select_query($query);

// Ensure services is an array
if (!is_array($services)) {
    $services = [];
}

// Handle service deletion
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_service'])) {
    $service_id = intval($_GET['delete_service']);

    // Ensure the service belongs to the logged-in business
    $query = "DELETE FROM services WHERE id = $service_id AND business_id = $business_id";
    $result = DatabaseHandler::make_modify_query($query);

    if ($result !== null) {
        $_SESSION['message'] = 'Service deleted successfully!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Error deleting service.';
        $_SESSION['message_type'] = 'danger';
    }

    header("Location: account.php");
    exit();
}

// If we are in edit mode, load the service to edit
$edit_service = null;
if (isset($_GET['service_id']) && is_numeric($_GET['service_id'])) {
    $service_id = (int) $_GET['service_id'];
    // Fetch service data for the selected service
    $query = "SELECT * FROM services WHERE id = $service_id AND business_id = $business_id";
    $edit_service = DatabaseHandler::make_select_query($query);
    $edit_service = $edit_service ? $edit_service[0] : null;

    if (!$edit_service) {
        $_SESSION['message'] = 'Service not found or access denied.';
        $_SESSION['message_type'] = 'danger';
        header("Location: account.php");
        exit();
    }
}

// Get popular tags for suggestions
function read($csv)
{
    $file = fopen($csv, 'r');
    while (!feof($file)) {
        $line[] = fgetcsv($file, 1024);
    }
    fclose($file);
    return $line;
}

$csv = __DIR__ . "/../../utilities/tags.csv";
$tags = read($csv);

// Get service metrics (for dashboard)
$query = "SELECT COUNT(*) as total_services FROM services WHERE business_id = $business_id";
$metrics = DatabaseHandler::make_select_query($query);
$total_services = $metrics[0]['total_services'] ?? 0;

// Get average rating
$query = "SELECT AVG(r.rating) as avg_rating, COUNT(r.id) as total_reviews 
          FROM reviews r 
          JOIN services s ON r.service_id = s.id 
          WHERE s.business_id = $business_id";
$ratings = DatabaseHandler::make_select_query($query);
$avg_rating = number_format($ratings[0]['avg_rating'] ?? 0, 1);
$total_reviews = $ratings[0]['total_reviews'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Business Account - The Artist Harbour</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Main Layout Containers */
        .profile-system-container {
            display: flex;
            flex-grow: 1;
            min-height: calc(100vh - 73.6px);
        }

        .sub-sidebar {
            background-color: #E2D4F0;
            min-height: calc(100vh - 73.6px);
            padding: 10px;
            border-right: #B3AABA 2px solid;
            display: flex;
            flex-direction: column;
        }

        .profile-title-container {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #E2D4F0;
            border-bottom: #B3AABA 2px solid;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .profile-title {
            font-weight: bold;
            font-size: 1.5rem;
            color: #49375a;
            margin: 20px;
        }

        .profile-content-container {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 73.6px);
            overflow: auto;
            background-color: #fff;
        }

        /* Profile Picture Styling */
        .profile-picture-container {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto;
            border: 3px solid #9074a8;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            background-color: #f8f9fa;
        }

        .profile-picture-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-picture-icon {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ac8ebf;
        }

        /* User Info Styling */
        .user-info-container {
            text-align: center;
            padding: 20px;
            flex-grow: 1;
            overflow-y: auto;
            margin-top: 20px;
        }

        .user-name {
            font-size: 1.3rem;
            font-weight: 600;
            color: #49375a;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        .user-email {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .content-padding {
            padding: 20px !important;
        }

        /* Card Styling */
        .card {
            background-color: #ddd2f1;
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        /* Service Section Styling */
        .services-section {
            margin-bottom: 30px;
        }

        .section-title {
            color: #49375a;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0d8f3;
        }

        /* Service Grid and Cards */
        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            padding: 15px;
        }

        .service-item {
            border: 1px solid #e0d8f3;
            border-radius: 12px;
            background-color: #fdfcff;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .service-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(130, 104, 154, 0.2);
            border-color: #82689A;
        }

        .service-image {
            width: 100%;
            height: 200px;
            position: relative;
            overflow: hidden;
            background-color: #f0f0f0;
            border-radius: 10px 10px 0 0;
        }

        .service-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .service-item:hover .service-image img {
            transform: scale(1.05);
        }

        .service-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(130, 104, 154, 0.85);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            z-index: 2;
        }

        .service-details {
    padding: 15px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    background-color: #fff;
}

    /* Improved Service Card Styling for account.php */
.service-details {
    padding: 15px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    background-color: #fff;
}

.service-details h4 {
    color: #4a3b5c;
    margin-top: 0;
    margin-bottom: 10px;
    font-size: 1.2rem;
}

.service-details p {
    color: #777;
    margin-bottom: 15px;
    flex-grow: 1;
}

.service-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    padding-top: 15px;
    border-top: 1px solid #f0f0f0;
}

.service-price {
    font-weight: bold;
    color: #4a2c5d;
}

.service-actions {
    display: flex;
    gap: 5px;
}


        .service-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-bottom: 15px;
        }

        .tag {
            background-color: #e0d8f3;
            color: #49375a;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.8rem;
            transition: background-color 0.2s ease;
        }

        .tag:hover {
            background-color: #c9b8e0;
        }

        



        /* Dashboard Cards */
        .dashboard-card {
            background-color: #ddd2f1;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: 1px solid #d1c2e9;
            margin-bottom: 20px;
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card h3 {
            font-size: 2rem;
            font-weight: 600;
            color: #49375a;
            margin-bottom: 5px;
        }

        .dashboard-card p {
            color: #6c757d;
            margin-bottom: 0;
        }

        /* Form Styling */
        .form-floating>label {
            color: #6c757d;
        }

        .form-floating>.form-control:focus~label,
        .form-floating>.form-control:not(:placeholder-shown)~label {
            color: #82689A;
            opacity: 0.8;
        }

        .form-control:focus {
            border-color: #ac8ebf;
            box-shadow: 0 0 0 0.25rem rgba(130, 104, 154, 0.25);
        }

        .form-check-input:checked {
            background-color: #82689A;
            border-color: #82689A;
        }

        /* Service Form Styling */
        .service-form {
            background-color: #f8f5ff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(130, 104, 154, 0.1);
            margin-bottom: 30px;
        }

        .service-form .card-header {
            background-color: #82689A;
            color: white;
            border-radius: 12px 12px 0 0;
            padding: 15px 20px;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .service-form .card-body {
            padding: 25px;
        }

        .service-form .form-label {
            font-weight: 500;
            color: #49375a;
            margin-bottom: 8px;
        }

        .service-form .form-control,
        .service-form .form-select {
            border: 1px solid #e0d8f3;
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .service-form .form-control:focus,
        .service-form .form-select:focus {
            border-color: #82689A;
            box-shadow: 0 0 0 0.25rem rgba(130, 104, 154, 0.25);
        }

        .service-form .form-text {
            color: #6c757d;
            font-size: 0.85rem;
            margin-top: 5px;
        }


       


        /* Tag Selection Styling */
        .tag-selection {
            max-height: 150px;
            overflow-y: auto;
            background-color: #fff;
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px;
            scrollbar-width: thin;
            scrollbar-color: #ac8ebf #f0ebf7;
        }

        .tag-selection::-webkit-scrollbar {
            width: 8px;
        }

        .tag-selection::-webkit-scrollbar-track {
            background: #f0ebf7;
            border-radius: 8px;
        }

        .tag-selection::-webkit-scrollbar-thumb {
            background-color: #ac8ebf;
            border-radius: 8px;
        }

        .form-check-inline {
            margin-right: 8px;
            margin-bottom: 8px;
        }

        .form-check-input:checked+.form-check-label {
            color: #82689A;
            font-weight: 500;
        }

        /* Button Styling */
        .btn-primary {
            background-color: #82689A;
            border-color: #70578c;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #70578c;
            border-color: #5f4a7b;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary {
            background-color: #ac8ebf;
            border-color: #ac8ebf;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #9a7dac;
            border-color: #9a7dac;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Image Preview */
        .image-preview-container {
            margin-top: 15px;
        }

        .image-preview {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: none;
            transition: opacity 0.3s ease;
        }

        .current-image {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
        }

        .current-image-label {
            font-weight: 500;
            color: #49375a;
            margin-bottom: 8px;
            display: block;
        }

        /* Tab Navigation */
        .nav-tabs {
            border-bottom: 1px solid #d1c2e9;
        }

        .nav-tabs .nav-link {
            color: #6c757d;
            border: none;
            padding: 10px 20px;
            border-radius: 0;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .nav-tabs .nav-link:hover {
            color: #49375a;
            background-color: #f0ebf7;
        }

        .nav-tabs .nav-link.active {
            color: #49375a;
            background-color: transparent;
            border-bottom: 3px solid #82689A;
        }

        /* Empty State Styling */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            background-color: #f8f5ff;
            border-radius: 10px;
            border: 1px dashed #d1c2e9;
        }

        .empty-state i {
            font-size: 3.5rem;
            color: #ac8ebf;
            margin-bottom: 15px;
            display: block;
        }

        .empty-state h5 {
            color: #49375a;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #6c757d;
            max-width: 400px;
            margin: 0 auto 15px;
        }

        /* Form Actions Styling */
        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
        }

        .form-actions .btn {
            padding: 10px 20px;
            font-weight: 500;
        }

        /* Responsive Adjustments */
        @media (max-width: 1199.98px) {
            .service-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 991.98px) {
            .service-grid {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
                gap: 15px;
            }

            .service-actions {
                flex-direction: column;
            }

            .service-actions .btn {
                width: 100%;
                margin-bottom: 5px;
            }

            .dashboard-card h3 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 767.98px) {
            .service-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }

            .form-actions {
                flex-direction: column;
                gap: 10px;
            }

            .form-actions .btn {
                width: 100%;
            }

            .nav-tabs .nav-link {
                padding: 8px 15px;
                font-size: 0.9rem;
            }

            .profile-title {
                font-size: 1.3rem;
            }

            .dashboard-card {
                padding: 15px;
            }
        }

        @media (max-width: 575.98px) {
            .service-grid {
                grid-template-columns: 1fr;
            }

            .user-name {
                font-size: 1.1rem;
            }

            .profile-picture-container {
                width: 80px;
                height: 80px;
            }

            .service-details h4 {
                font-size: 1.1rem;
            }

            .service-details p {
                font-size: 0.9rem;
            }

            .tag {
                font-size: 0.7rem;
                padding: 2px 6px;
            }

            .service-price {
                font-size: 0.9rem;
            }

            .service-image {
                height: 180px;
            }

            .empty-state {
                padding: 30px 15px;
            }

            .empty-state i {
                font-size: 2.5rem;
            }
        }

        /* Alert Styling */
        .alert {
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .alert-success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #4caf50;
        }

        .alert-danger {
            background-color: #ffebee;
            color: #c62828;
            border-left: 4px solid #f44336;
        }

        .alert-warning {
            background-color: #fff8e1;
            color: #f57f17;
            border-left: 4px solid #ffc107;
        }

        .alert-info {
            background-color: #e3f2fd;
            color: #1565c0;
            border-left: 4px solid #2196f3;
        }

        /* Collapsible Form Styling */
        .collapse {
            transition: all 0.3s ease;
        }

        .collapsing {
            transition: all 0.3s ease;
        }

        /* Service Card Hover Effects */
        .service-item .btn {
            transition: all 0.2s ease;
        }

        .service-item:hover .btn-primary {
            background-color: #70578c;
        }

        .service-item:hover .btn-danger {
            background-color: #c82333;
        }

        /* Price Range Display */
        .price-range {
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: 500;
        }

        .price-range .price-dash {
            color: #6c757d;
        }

        .price-range .price-value {
            color: #4a2c5d;
        }


        div {
            padding: 0 !important;
        }

        /* Custom Checkbox Styling */
        .custom-checkbox .form-check-input {
            border-radius: 0.25rem;
        }

        .custom-checkbox .form-check-input:checked {
            background-color: #82689A;
            border-color: #82689A;
        }

        .custom-checkbox .form-check-input:focus {
            border-color: #ac8ebf;
            box-shadow: 0 0 0 0.25rem rgba(130, 104, 154, 0.25);
        }
    </style>


</head>

<body>
    <div class="container-fluid">
        <div class="row g-0">
            <div class="col-12">
                <?php include __DIR__ . '/../../templates/header.php'; ?>
            </div>
        </div>

        <div class="row g-0 flex-grow-1 profile-system-container">
            <!-- Sidebar - hidden on small screens -->
            <div class="col-md-1 d-none d-md-block">
                <?php include __DIR__ . '/../../templates/sidebar.php'; ?>
            </div>

            <!-- Sub-sidebar with account info -->
            <div class="col-4 col-md-2 sub-sidebar">
                <div class="profile-title-container">
                    <h5 class="profile-title">Business Info</h5>
                </div>

                <div class="user-info-container">
                    <?php
                    // Fetch user data from the database, including profile_picture
                    $query = "SELECT profile_picture, first_name, last_name, email FROM users WHERE id = $user_id";
                    $userData = DatabaseHandler::make_select_query($query);

                    // Check if the user data was found and if the profile picture is not empty
                    $profile_picture = null;
                    $first_name = "";
                    $last_name = "";
                    $email = "";

                    if ($userData && count($userData) > 0) {
                        $profile_picture = $userData[0]['profile_picture'];
                        $first_name = $userData[0]['first_name'];
                        $last_name = $userData[0]['last_name'];
                        $email = $userData[0]['email'];
                    }
                    ?>

                    <div class="profile-picture-container">
                        <?php if ($profile_picture): ?>
                            <img src="../user/get_image.php?id=<?= $user_id ?>" alt="Profile Picture">
                        <?php else: ?>
                            <div class="profile-picture-icon text-white">
                                <i class="bi bi-person-fill" style="font-size: 3rem;"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <h4 class="user-name"><?php echo ($first_name . " " . $last_name); ?></h4>
                    <p class="user-email"><?php echo ($email); ?></p>

                    <h5 class="mt-4"><?php echo ($business_name); ?></h5>
                    <p class="text-muted small"><?php echo ($business_description); ?></p>

                    <div class="mt-4">
                        <a href="profile.php?business_id=<?php echo $business_id; ?>"
                            class="btn btn-sm btn-outline-primary w-100 mb-2">
                            <i class="bi bi-eye"></i> View Public Profile
                        </a>
                        <a href="../user/user_profile.php" class="btn btn-sm btn-outline-secondary w-100">
                            <i class="bi bi-person-gear"></i> User Settings
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <div class="col-8 col-md-9 profile-content-container">
                <div class="profile-title-container">
                    <h5 class="profile-title">Business Dashboard</h5>
                </div>

                <div class="content-padding">
                    <!-- Display messages if any -->
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show"
                            role="alert">
                            <?php echo $_SESSION['message']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php
                        // Clear the message after displaying it
                        unset($_SESSION['message']);
                        unset($_SESSION['message_type']);
                        ?>
                    <?php endif; ?>

                    <!-- Dashboard Stats -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="dashboard-card">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="bi bi-bag-check" style="font-size: 2.5rem; color: #82689A;"></i>
                                    </div>
                                    <div>
                                        <h3><?php echo $total_services; ?></h3>
                                        <p>Active Services</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="dashboard-card">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="bi bi-star" style="font-size: 2.5rem; color: #82689A;"></i>
                                    </div>
                                    <div>
                                        <h3><?php echo $avg_rating; ?></h3>
                                        <p><?php echo $total_reviews; ?> Reviews</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs mb-4" id="accountTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="details-tab" data-bs-toggle="tab"
                                data-bs-target="#details" type="button" role="tab" aria-controls="details"
                                aria-selected="true">
                                <i class="bi bi-info-circle me-1"></i> Business Details
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="services-tab" data-bs-toggle="tab" data-bs-target="#services"
                                type="button" role="tab" aria-controls="services" aria-selected="false">
                                <i class="bi bi-bag me-1"></i> Services
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social"
                                type="button" role="tab" aria-controls="social" aria-selected="false">
                                <i class="bi bi-share me-1"></i> Social Media
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="accountTabsContent">
                        <!-- Business Details Tab -->
                        <div class="tab-pane fade show active" id="details" role="tabpanel"
                            aria-labelledby="details-tab">
                            <div class="card p-3 mb-3">
                                <h5 class="mb-3">Business Details</h5>
                                <form method="POST" action="account.php" id="businessDetailsForm">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="business_name" name="business_name"
                                            value="<?php echo ($business_name); ?>"
                                            placeholder="Business Name" required>
                                        <label for="business_name">Business Name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" id="business_description"
                                            name="business_description" style="height: 120px"
                                            placeholder="Business Description"
                                            required><?php echo ($business_description); ?></textarea>
                                        <label for="business_description">Business Description</label>
                                        <div class="form-text">Describe your business, services, and what makes you
                                            unique.</div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">
                                        <i class="bi bi-save me-1"></i> Update Business Details
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Services Tab -->
                        <div class="tab-pane fade" id="services" role="tabpanel" aria-labelledby="services-tab">
                            <!-- Services Section -->
                            <div class="card p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">Available Services</h5>
                                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#addServiceForm" aria-expanded="false"
                                        aria-controls="addServiceForm">
                                        <i class="bi bi-plus-lg me-1"></i> Add New Service
                                    </button>
                                </div>

                                <!-- Add New Service Form (Collapsible) -->

                                <div class="collapse" id="addServiceForm">
                                    <div class="card p-3 mb-3">
                                        <form method="POST" action="account.php" enctype="multipart/form-data"
                                            id="newServiceForm">
                                            <!-- Service Name and Image Row -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="service_name" class="form-label">Service
                                                            Name</label>
                                                        <input type="text" class="form-control" id="service_name"
                                                            name="service_name" placeholder="Enter service name"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="service_image" class="form-label">Service
                                                            Image</label>
                                                        <input type="file" class="form-control" id="service_image"
                                                            name="service_image" accept="image/*"
                                                            onchange="previewImage(this, 'imagePreview')">
                                                        <div class="form-text">Recommended size: 800x600 pixels, max 2MB
                                                        </div>
                                                        <div class="mt-2">
                                                            <img id="imagePreview" class="image-preview" src="#"
                                                                alt="Image Preview"
                                                                style="display: none; max-height: 150px; max-width: 100%; border-radius: 8px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Service Description -->
                                            <div class="form-group mb-3">
                                                <label for="service_description" class="form-label">Service
                                                    Description</label>
                                                <textarea class="form-control" id="service_description"
                                                    name="service_description" rows="3"
                                                    placeholder="Describe your service..." required></textarea>
                                            </div>

                                            <!-- Tags Selection -->
                                            <div class="form-group mb-3">
                                                <label class="form-label">Tags</label>
                                                <div class="p-3 border rounded bg-white"
                                                    style="max-height: 150px; overflow-y: auto;">
                                                    <div class="row">
                                                        <?php
                                                        $i = 0;
                                                        while ($i < count($tags)) {
                                                            $tag = $tags[$i][0];
                                                            if (!empty($tag)) {
                                                                ?>
                                                                <div class="col-md-4 col-sm-6 mb-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="tags[<?php echo $i ?>]"
                                                                            id="tag_<?php echo $i ?>"
                                                                            value="<?php echo $tag ?>">
                                                                        <label class="form-check-label"
                                                                            for="tag_<?php echo $i ?>"><?php echo $tag ?></label>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                            $i++;
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="form-text">Select tags that best describe your service.
                                                </div>
                                            </div>

                <!-- Pricing Options -->
<div class="form-group mb-3">
    <label class="form-label">Pricing</label>
    <div class="mb-3">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="service_negotiable" name="service_negotiable">
            <label class="form-check-label" for="service_negotiable">Negotiable Pricing</label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <input type="number" step="0.01" class="form-control" id="service_min_price" name="service_min_price" placeholder="Min Price (€)" disabled>
            <div class="form-text">Minimum price (only for negotiable pricing)</div>
        </div>
        <div class="col-md-6">
            <input type="number" step="0.01" class="form-control" id="service_max_price" name="service_max_price" placeholder="Max Price (€)" required>
            <div class="form-text">Maximum/fixed price</div>
        </div>
    </div>
</div>



                                            <!-- Form Actions -->
                                            <div class="d-flex justify-content-between mt-4">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-toggle="collapse" data-bs-target="#addServiceForm">
                                                    <i class="bi bi-x-lg me-1"></i> Cancel
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bi bi-plus-lg me-1"></i> Add Service
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                </>


                                <?php if ($services && count($services) > 0): ?>
                                    <div class="service-grid">
                                        <?php foreach ($services as $service): ?>
                                            <div class="service-item">
                                                <div class="service-image">
                                                    <?php if (!empty($service['image'])): ?>
                                                            <img src="./get_serviceImage.php?id=<?= $service['id'] ?>"
                                                                alt="<?php echo ($service['name']); ?>">
                                                    <?php else: ?>
                                                            <img src="../../public/images/default.png" alt="Default Service Image">
                                                    <?php endif; ?>
                                                </div>
                                                <div class="service-details">
                                                    <h4><?php echo ($service['name']); ?></h4>

                                                    <?php if (!empty($service['tags'])): ?>
                                                            <div class="service-tags">
                                                                <?php
                                                                $tagArray = explode(',', $service['tags']);
                                                                foreach ($tagArray as $tag):
                                                                    if (trim($tag) !== ''):
                                                                        ?>
                                                                                <span class="tag"><?php echo (trim($tag)); ?></span>
                                                                                <?php
                                                                    endif;
                                                                endforeach;
                                                                ?>
                                                            </div>
                                                    <?php endif; ?>

                                                    <p><?php echo ($service['description']); ?></p>

                                                    <div class="service-meta">
                                                        <div class="service-price">
                                                            <?php
                                                            if (isset($service['min_price']) && $service['min_price'] !== null) {
                                                                echo '€' . ($service['min_price']) . " - €" . ($service['max_price']);
                                                            } else {
                                                                echo '€' . ($service['max_price']);
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="service-actions">
                                                            <a href="account.php?service_id=<?php echo $service['id']; ?>"
                                                                class="btn btn-sm btn-primary">
                                                                <i class="bi bi-pencil"></i> Edit
                                                            </a>
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                onclick="confirmDelete(<?php echo $service['id']; ?>)">
                                                                <i class="bi bi-trash"></i> Delete
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="text-center py-5">
                                        <i class="bi bi-bag-x" style="font-size: 3rem; color: #ccc;"></i>
                                        <p class="mt-3">No services available yet.</p>
                                        <p class="text-muted">Add your first service to start attracting customers.</p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Edit Service Form (if in edit mode) -->
                            <?php if ($edit_service): ?>
                                <div class="card p-3 mb-3">
                                    <h5 class="mb-3">Edit Service</h5>
                                    <form method="POST" action="account.php" enctype="multipart/form-data">
                                        <input type="hidden" name="service_id" value="<?php echo $edit_service['id']; ?>">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="edit_service_name"
                                                        name="service_name"
                                                        value="<?php echo ($edit_service['name']); ?>"
                                                        placeholder="Service Name" required>
                                                    <label for="edit_service_name">Service Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="edit_service_image" class="form-label">Service Image</label>
                                                    <input type="file" class="form-control" id="edit_service_image"
                                                        name="service_image" accept="image/*"
                                                        onchange="previewImage(this, 'editImagePreview')">
                                                    <div class="form-text">Leave blank to keep current image</div>

                                                    <?php if (!empty($edit_service['image'])): ?>
                                                        <div class="mt-2">
                                                            <p class="mb-1">Current image:</p>
                                                            <img src="./get_serviceImage.php?id=<?= $edit_service['id'] ?>"
                                                                alt="Current Service Image"
                                                                style="max-width: 150px; max-height: 150px; border-radius: 5px;">
                                                        </div>
                                                    <?php endif; ?>

                                                    <img id="editImagePreview" class="image-preview" src="#"
                                                        alt="New Image Preview">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" id="edit_service_description"
                                                name="service_description" style="height: 100px"
                                                placeholder="Service Description"
                                                required><?php echo ($edit_service['description']); ?></textarea>
                                            <label for="edit_service_description">Service Description</label>
                                        </div>
<!-- Tags Selection for Edit Service Form -->
<div class="form-group mb-3">
    <label class="form-label">Tags</label>
    <div class="p-3 border rounded bg-white" style="max-height: 150px; overflow-y: auto;">
        <div class="row">
            <?php
            $i = 0;
            // Parse existing tags from the service
            $existing_tags = explode(',', $edit_service['tags']);
            $existing_tags = array_map('trim', $existing_tags);
            
            while ($i < count($tags)) {
                $tag = $tags[$i][0];
                $is_checked = in_array($tag, $existing_tags) ? 'checked' : '';
                if (!empty($tag)) {
                    ?>
                    <div class="col-md-4 col-sm-6 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="tags[<?php echo $i ?>]"
                                id="edit_tag_<?php echo $i ?>"
                                value="<?php echo $tag ?>" <?php echo $is_checked; ?>>
                            <label class="form-check-label"
                                for="edit_tag_<?php echo $i ?>"><?php echo $tag ?></label>
                        </div>
                    </div>
                    <?php
                }
                $i++;
            }
            ?>
        </div>
    </div>
    <div class="form-text">Select tags that best describe your service.</div>
</div>
<div class="form-group mb-3">
    <label class="form-label">Pricing</label>
    <div class="mb-3">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="service_negotiable" name="service_negotiable" <?php echo $edit_service['min_price'] ? 'checked' : ''; ?>>
            <label class="form-check-label" for="service_negotiable">Negotiable Pricing</label>
        </div>
    </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="number" step="0.01" class="form-control"
                                                        id="edit_service_min_price" name="service_min_price"
                                                        value="<?php echo $edit_service['min_price']; ?>"
                                                        placeholder="Min Price" <?php echo $edit_service['min_price'] ? "" : "disabled"; ?>>
                                                    <label for="edit_service_min_price">Min Price (€)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="number" step="0.01" class="form-control"
                                                        id="edit_service_max_price" name="service_max_price"
                                                        value="<?php echo $edit_service['max_price']; ?>"
                                                        placeholder="Max Price" required>
                                                    <label for="edit_service_max_price">Max Price (€)</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <a href="account.php" class="btn btn-outline-secondary">
                                                <i class="bi bi-x-lg me-1"></i> Cancel
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-check-lg me-1"></i> Update Service
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Social Media Tab -->
                        <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                            <div class="card p-3 mb-3">
                                <h5 class="mb-3">Social Media Links</h5>
                                <form method="POST" action="account.php">
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i
                                                    class="bi bi-instagram text-danger"></i></span>
                                            <div class="form-floating">
                                                <input type="url" class="form-control" id="instagram" name="instagram"
                                                    placeholder="Instagram Link"
                                                    value="<?php echo ($instagram); ?>">
                                                <label for="instagram">Instagram Link</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i
                                                    class="bi bi-facebook text-primary"></i></span>
                                            <div class="form-floating">
                                                <input type="url" class="form-control" id="facebook" name="facebook"
                                                    placeholder="Facebook Link"
                                                    value="<?php echo ($facebook); ?>">
                                                <label for="facebook">Facebook Link</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i
                                                    class="bi bi-tiktok text-dark"></i></span>
                                            <div class="form-floating">
                                                <input type="url" class="form-control" id="tiktok" name="tiktok"
                                                    placeholder="TikTok Link"
                                                    value="<?php echo ($tiktok); ?>">
                                                <label for="tiktok">TikTok Link</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i
                                                    class="bi bi-pinterest text-danger"></i></span>
                                            <div class="form-floating">
                                                <input type="url" class="form-control" id="pinterest" name="pinterest"
                                                    placeholder="Pinterest Link"
                                                    value="<?php echo ($pinterest); ?>">
                                                <label for="pinterest">Pinterest Link</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i
                                                    class="bi bi-globe text-success"></i></span>
                                            <div class="form-floating">
                                                <input type="url" class="form-control" id="website" name="website"
                                                    placeholder="Website Link"
                                                    value="<?php echo ($website); ?>">
                                                <label for="website">Website Link</label>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary" type="submit">
                                        <i class="bi bi-save me-1"></i> Update Social Media Links
                                    </button>
                                </form>
                            </div>

                            <!-- Social Media Preview -->
                            <div class="card p-3 mb-3">
                                <h5 class="mb-3">Social Media Preview</h5>
                                <div class="social-preview p-3 border rounded bg-white">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="me-3"
                                            style="width: 60px; height: 60px; border-radius: 50%; overflow: hidden; background-color: #f0f0f0;">
                                            <?php if ($profile_picture): ?>
                                                <img src="../user/get_image.php?id=<?= $user_id ?>" alt="Profile Picture"
                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                            <?php else: ?>
                                                <div
                                                    class="d-flex align-items-center justify-content-center h-100 bg-secondary text-white">
                                                    <i class="bi bi-person-fill" style="font-size: 2rem;"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <h5 class="mb-0"><?php echo ($business_name); ?></h5>
                                            <p class="text-muted mb-0">Business · Art & Design</p>
                                        </div>
                                    </div>
                                    <p><?php echo ($business_description); ?></p>
                                    <div class="d-flex gap-2 mt-3">
                                        <button class="btn btn-sm btn-outline-primary" disabled>
                                            <i class="bi bi-share"></i> Share
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary" disabled>
                                            <i class="bi bi-bookmark"></i> Save
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary" disabled>
                                            <i class="bi bi-hand-thumbs-up"></i> Like
                                        </button>
                                    </div>
                                </div>
                                <div class="form-text mt-2">This is how your business might appear when shared on social
                                    media platforms.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <!-- Delete Service Confirmation Modal -->
    <div class="modal fade" id="deleteServiceModal" tabindex="-1" aria-labelledby="deleteServiceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteServiceModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this service? This action cannot be undone.</p>
                    <p class="text-muted small">Note: Deleting a service will also remove all associated reviews and
                        requests.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Delete Service</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notifications Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle me-2"></i> <span id="successToastMessage">Operation completed
                        successfully!</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script>
        // Toggle the min price field based on negotiable checkbox
        document.addEventListener('DOMContentLoaded', function () {
            // Handle negotiable checkbox for new service form
            const serviceNegotiable = document.getElementById('service_negotiable');
            if (serviceNegotiable) {
                serviceNegotiable.addEventListener('change', function () {
                    const minPriceField = document.getElementById('service_min_price');
                    minPriceField.disabled = !this.checked;
                    if (!this.checked) {
                        minPriceField.value = '';
                    }
                });
            }

            // Handle negotiable checkbox for edit service form
            const editServiceNegotiable = document.getElementById('edit_service_negotiable');
            if (editServiceNegotiable) {
                editServiceNegotiable.addEventListener('change', function () {
                    const minPriceField = document.getElementById('edit_service_min_price');
                    minPriceField.disabled = !this.checked;
                    if (!this.checked) {
                        minPriceField.value = '';
                    }
                });
            }

            // Show active tab based on URL hash or if editing a service
            const urlHash = window.location.hash;
            if (urlHash) {
                const tab = document.querySelector(`a[href="${urlHash}"]`);
                if (tab) {
                    tab.click();
                }
            } else if (<?php echo isset($_GET['service_id']) ? 'true' : 'false'; ?>) {
                // If editing a service, show the services tab
                document.getElementById('services-tab').click();
            }

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Show toast notification if there's a message
            <?php if (isset($_SESSION['message'])): ?>
                const successToast = new bootstrap.Toast(document.getElementById('successToast'));
                document.getElementById('successToastMessage').textContent = '<?php echo $_SESSION['message']; ?>';
                successToast.show();
            <?php endif; ?>
        });

        // Function to preview image before upload
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            preview.style.display = 'none';

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Function to handle service deletion confirmation
        function confirmDelete(serviceId) {
            const modal = new bootstrap.Modal(document.getElementById('deleteServiceModal'));
            const confirmBtn = document.getElementById('confirmDeleteBtn');
            confirmBtn.href = `account.php?delete_service=${serviceId}`;
            modal.show();
        }
    </script>
</body>

</html>
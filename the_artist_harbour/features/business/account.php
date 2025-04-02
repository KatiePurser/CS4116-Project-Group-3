<?php
session_start();
include_once __DIR__ . '/../../utilities/databaseHandler.php';
include_once __DIR__ . '/../../utilities/imageHandler.php';
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


// Fetch the business data in a single query
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
        DatabaseHandler::make_modify_query($query);
        
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
        DatabaseHandler::make_modify_query($query);
    }

$query = "SELECT * FROM services WHERE business_id = $business_id";
$services = DatabaseHandler::make_select_query($query);

// Ensure services is an array
if (!is_array($services)) {
    $services = [];
}

// Handle adding a new service
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['service_name'])) {
    // Collect form data for the new service
    $service_name = filter_input(INPUT_POST, 'service_name', FILTER_SANITIZE_STRING);
    $service_description = filter_input(INPUT_POST, 'service_description', FILTER_SANITIZE_STRING);
    $service_tags = filter_input(INPUT_POST, 'service_tags', FILTER_SANITIZE_STRING);
    
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
        echo "<script>alert('Both min and max prices are required when negotiable is true.');</script>";
        exit();
    } elseif (!$negotiable && !$max_price) {
        echo "<script>alert('Max price is required when negotiable is false.');</script>";
        exit();
    }

   // Handle the image upload for the new service using imagehandler class
   $service_image = null; 
    if (isset($_FILES['service_image']) ) {
        $service_image = ImageHandler::uploadAndStoreImage('service_image', 'services', 'image', 'id', $business_id);
        $messages[] = $uploadMessage;
    }

    // Insert the new service into the database
    $insert_query = "INSERT INTO services (business_id, name, description, tags, min_price, max_price, image, created_at) 
    VALUES (
        $business_id, 
        '" . addslashes($service_name) . "', 
        '" . addslashes($service_description) . "', 
        '" . addslashes($service_tags) . "', 
        " . ($min_price !== null ? $min_price : "NULL") . ", 
        " . ($max_price !== null ? $max_price : "NULL") . ", 
        " . ($service_image ? "'".addslashes($service_image)."'" : "NULL") . ",  
        NOW()
    )";



    $result = DatabaseHandler::make_modify_query($insert_query);
    if ($result) {
        echo "<script>alert('New service added successfully!');</script>";
        header("Location: account.php");
        exit();
    } else {
        echo "<script>alert('Error adding service. Please try again.');</script>";
    }
}
}
// Fetch all services related to this business
$query = "SELECT * FROM services WHERE business_id = $business_id";
$services = DatabaseHandler::make_select_query($query);

// Handle service deletion
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_service'])) {
    $service_id = intval($_GET['delete_service']);
    
    // Ensure the service belongs to the logged-in business
    $query = "DELETE FROM services WHERE id = $service_id AND business_id = $business_id";
    DatabaseHandler::make_modify_query($query);
    
    echo "<script>alert('Service deleted successfully!'); window.location='account.php';</script>";
    exit();
}


// If we are in edit mode, load the service to edit
$edit_service = null;
if (isset($_GET['service_id']) && is_numeric($_GET['service_id'])) {
    $service_id = (int)$_GET['service_id'];
    // Fetch service data for the selected service
    $query = "SELECT * FROM services WHERE id = $service_id AND business_id = $business_id";
    $edit_service = DatabaseHandler::make_select_query($query);
    $edit_service = $edit_service ? $edit_service[0] : null;

    if (!$edit_service) {
        die("Service not found or access denied.");
    }
}

// Handle form submission for editing service
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['service_id'])) {
    $service_name = filter_input(INPUT_POST, 'service_name', FILTER_SANITIZE_STRING);
    $service_description = filter_input(INPUT_POST, 'service_description', FILTER_SANITIZE_STRING);
    $service_tags = filter_input(INPUT_POST, 'service_tags', FILTER_SANITIZE_STRING);
    $negotiable = isset($_POST['service_negotiable']) ? 1 : 0;
    $min_price = $negotiable && isset($_POST['service_min_price']) ? filter_input(INPUT_POST, 'service_min_price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : null;
    $max_price = filter_input(INPUT_POST, 'service_max_price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    if ($negotiable && (!$min_price || !$max_price)) {
        echo "<script>alert('Both min and max prices are required when negotiable is true.');</script>";
        exit();
    } elseif (!$negotiable && !$max_price) {
        echo "<script>alert('Max price is required when negotiable is false.');</script>";
        exit();
    }

     // Handle image upload using ImageHandler
     if (isset($_FILES['service_image']) && $_FILES['service_image']['error'] === UPLOAD_ERR_OK) {
        $uploadResult = ImageHandler::uploadAndStoreImage('service_image', 'services', 'image', 'id', $service_id);
        if ($uploadResult !== "service image uploaded successfully!") {
            echo "<script>alert('Error uploading image.');</script>";
            exit();
        }
    }

    // Update the service in the database
    $query = "UPDATE services SET 
                name = '$service_name', 
                description = '$service_description',
                tags = '$service_tags',
                min_price = " . ($min_price ? $min_price : "NULL") . ",
                max_price = " . ($max_price ? $max_price : "NULL") . ",
                image = '" . ($service_image ? addslashes($service_image) : "NULL") . "'
              WHERE id = {$_POST['service_id']} AND business_id = $business_id";

    $result = DatabaseHandler::make_modify_query($query);

    if ($result) {
        echo "<script>alert('Service updated successfully!'); window.location='account.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error updating service. Please try again.');</script>";
    }
}
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
        }
        .account-container {
            background-color: #e6dfe5;
            padding: 20px;
        }
        .card {
            background-color: #ddd2f1;
            border-radius: 10px;
        }
        .btn-primary {
            background-color: #82689A;
            border-color: #9074a8;
        }
        .btn-secondary {
            background-color: #ac8ebf;
            border-color: #ac8ebf;
        }
        .sidebar-container {
            background-color: #9074a8;
            min-height: 100vh;
        }
        .subheader {
            background-color: #ddd2f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            text-align: center;
            border-bottom: 1px solid #49375a;
        }
        .subheader-title {
            padding: 10px;
            font-weight: bold;
            font-size: 1.5rem;
            color: #49375a;
        }
        .profile-picture-container {
            width: clamp(90px, 20vw, 150px);
            height: clamp(90px, 20vw, 150px);
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto; 
}


        .profile-picture {
           width: 100%;
           height: 100%;
           object-fit: cover;     
}

.sub-sidebar {
    background-color: #ddd2f1; 
    min-height: calc(100vh - 56px - 53px);
   
    display: flex;
    flex-direction: column;
    align-items: center; 
    justify-content: flex-start; 
    text-align: center; 
}

        div {
            padding: 0 !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row g-0">
            <div class="col-12">
                <?php include __DIR__ . '/../../templates/header.php'; ?>
            </div>
            <div class="col-12 subheader">
                <h>Business</h>
            </div>
        </div>
        <div class="row g-0">
            <div class="col-1">
                <?php include __DIR__ . '/../../templates/sidebar.php'; ?>
            </div>
            
            <!-- Sub-sidebar with account info -->
           
                <?php
// Fetch user data from the database, including profile_picture
$query = "SELECT profile_picture FROM users WHERE id = $user_id";
$userData = DatabaseHandler::make_select_query($query);

// Check if the user data was found and if the profile picture is not empty
$profile_picture = null;
if ($userData && count($userData) > 0) {
    $profile_picture = $userData[0]['profile_picture'];
}

?>     
 <div class="col-2 sub-sidebar">
<div class="text-center">
<?php if ($profile_picture): ?>
<div class="profile-picture-container">
<img src="../user/get_image.php?id=<?= $user_id ?>" class="profile-picture">
</div>
<?php else: ?>
<div class="profile-picture-container bg-secondary text-white d-flex align-items-center justify-content-center">
<i class="bi bi-person fs-1"></i>
</div>
<?php endif; ?>

                    <h4 id="businessName" class="mt-2"><?php echo htmlspecialchars($business_name); ?></h4>
                    <button class="btn btn-light btn-sm" onclick="editField('businessName')">Edit</button>
                    <p class="text-muted" id="businessDescription"><?php echo htmlspecialchars($business_description); ?></p>
                    <button class="btn btn-light btn-sm" onclick="editField('businessDescription')">Edit</button>
                </div>
            </div>
        
            <!-- Main content area -->
            <div class="col-9 p-4">
                <!-- Business Details Card -->
                <div class="card p-3 mb-3">
                    <h5>Business Details</h5>
                    <form method="POST" action="account.php">
                        <input type="text" class="form-control mb-2" name="business_name" value="<?php echo htmlspecialchars($business_name); ?>">
                        <textarea class="form-control mb-2" name="business_description"><?php echo htmlspecialchars($business_description); ?></textarea>
                        <button class="btn btn-secondary" type="submit">Update Business Details</button>
                    </form>
                </div>

                <!-- Social Media Links Card -->
                <div class="card p-3 mb-3">
                    <h5>Social Media Links</h5>
                    <form method="POST" action="account.php">
                        <input type="url" class="form-control mb-2" name="instagram" placeholder="Instagram Link" value="<?php echo htmlspecialchars($instagram); ?>">
                        <input type="url" class="form-control mb-2" name="facebook" placeholder="Facebook Link" value="<?php echo htmlspecialchars($facebook); ?>">
                        <input type="url" class="form-control mb-2" name="tiktok" placeholder="TikTok Link" value="<?php echo htmlspecialchars($tiktok); ?>">
                        <input type="url" class="form-control mb-2" name="pinterest" placeholder="Pinterest Link" value="<?php echo htmlspecialchars($pinterest); ?>">
                        <input type="url" class="form-control mb-2" name="website" placeholder="Website Link" value="<?php echo htmlspecialchars($website); ?>">
                        <button class="btn btn-secondary" type="submit">Update Social Media Links</button>
                    </form>
                    </div>
                    
    <!-- Service Cards: Loop through services dynamically -->
  <h5>Services</h5>
              
              <div class="card p-3 mb-3">
              <h5>Available Services</h5>
<div class="row">
    <?php if ($services && count($services) > 0): ?>
        <?php foreach ($services as $service): ?>
            <div class="col-md-4">
                <div class="card p-3 mb-4 shadow-sm">
                    <!-- Display Image if Exists -->
                    <?php if (!empty($service['image'])): ?>
                        <img src="/../../utilities/image_handler.php?service_id=<?= $service['id'] ?>" class="card-img-top" alt="Service Image">


                    <?php else: ?>
                        <img src="../../public/images/default-service.png" class="card-img-top" alt="Default Image" style="max-height: 200px; object-fit: cover;">
                    <?php endif; ?>

                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($service['name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($service['description']); ?></p>
                        <p class="text-muted"><strong>Tags:</strong> <?php echo htmlspecialchars($service['tags']); ?></p>
                        <p><strong>Price:</strong> 
                            <?php 
                                echo isset($service['min_price']) && $service['min_price'] !== null 
                                    ? htmlspecialchars($service['min_price']) . " - " . htmlspecialchars($service['max_price']) 
                                    : htmlspecialchars($service['max_price']); 
                            ?>
                        </p>

                        <div class="d-flex justify-content-between">
                        <a href="account.php?service_id=<?php echo $service['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="account.php?delete_service=<?php echo $service['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this service?');">Delete</a>

                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No services available for this business yet.</p>
    <?php endif; ?>
</div>
          
        <!-- Edit Service Form -->
        <?php if ($edit_service): ?>
            <div class="card p-3 mb-3">
                <h5>Edit Service</h5>
                <form method="POST" action="account.php" enctype="multipart/form-data">
                    <input type="hidden" name="service_id" value="<?php echo $edit_service['id']; ?>">
                    <div class="mb-3">
                        <label for="service_name" class="form-label">Service Name</label>
                        <input type="text" class="form-control" id="service_name" name="service_name" value="<?php echo htmlspecialchars($edit_service['name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="service_description" class="form-label">Description</label>
                        <textarea class="form-control" id="service_description" name="service_description" required><?php echo htmlspecialchars($edit_service['description']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="service_tags" class="form-label">Tags (comma separated)</label>
                        <input type="text" class="form-control" id="service_tags" name="service_tags" value="<?php echo htmlspecialchars($edit_service['tags']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="service_min_price" class="form-label">Min Price</label>
                        <input type="number" class="form-control" id="service_min_price" name="service_min_price" value="<?php echo $edit_service['min_price']; ?>" <?php echo $edit_service['min_price'] ? "" : "disabled"; ?>>
                    </div>
                    <div class="mb-3">
                        <label for="service_max_price" class="form-label">Max Price</label>
                        <input type="number" class="form-control" id="service_max_price" name="service_max_price" value="<?php echo $edit_service['max_price']; ?>" required>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="service_negotiable" name="service_negotiable" <?php echo $edit_service['min_price'] ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="service_negotiable">Negotiable</label>
                    </div>
                    <div class="mb-3">
                        <label for="service_image" class="form-label">Service Image</label>
                        <input type="file" class="form-control" id="service_image" name="service_image" accept="image/*">
                        <small class="form-text text-muted">Leave blank to keep the current image.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Service</button>
                </form>
            </div>
        <?php endif; ?>

                <!-- Add New Service Form -->
                <div class="card p-3 mb-3">
    <h5>Add a New Service</h5>
    <form method="POST" action="account.php" enctype="multipart/form-data">
        <input type="text" class="form-control mb-2" name="service_name" placeholder="Service Name" required>
        <textarea class="form-control mb-2" name="service_description" placeholder="Service Description" required></textarea>
        <input type="text" class="form-control mb-2" name="service_tags" placeholder="Tags (Comma separated)" required>
        
        <div class="d-flex gap-2 mb-2">
            <input type="text" class="form-control" name="service_min_price" id="service_min_price" placeholder="Min Price" disabled>
            <input type="text" class="form-control" name="service_max_price" placeholder="Max Price" required>
        </div>

        <div class="d-flex align-items-center mb-2">
            <input type="checkbox" class="me-2" name="service_negotiable" id="service_negotiable"> Negotiable
        </div>

        <input type="file" class="form-control mb-2" name="service_image" accept="image/*">

        <button class="btn btn-secondary" type="submit">Add Service</button>
    </form>


<script>
    // Toggle the min price field based on negotiable checkbox
    document.getElementById('service_negotiable').addEventListener('change', function() {
        var minPriceField = document.getElementById('service_min_price');
        if (this.checked) {
            minPriceField.disabled = false;
        } else {
            minPriceField.disabled = true;
        }
    });
</script>
            </div>
        </div>
    </div>
</body>
</html>

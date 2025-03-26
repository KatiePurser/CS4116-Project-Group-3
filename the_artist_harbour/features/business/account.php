<?php
// Include the necessary files (for database connection, etc.)
include_once __DIR__ . '/../../utilities/databaseHandler.php';

// Fetch the business ID from session

if(!isset($_SESSION['user_id'])){
    header ("Location: ../../features/registration-login/Login.php");
    exit();
} 
if ($_SESSION[ 'user_type'] !== 'business'){

exit();
}

// Fetch business data from the database
$query = "SELECT * FROM businesses WHERE id = $business_id";
$businessData = DatabaseHandler::make_select_query($query);

// If no data found, use defaults
if ($businessData && count($businessData) > 0) {
    $business_name = $businessData[0]['display_name'];
    $business_description = $businessData[0]['description'];
    $instagram = $businessData[0]['instagram'];
    $facebook = $businessData[0]['facebook'];
    $tiktok = $businessData[0]['tiktok'];
    $pinterest = $businessData[0]['pinterest'];
    $website = $businessData[0]['website'];
} else {
    // Default data in case the query fails or no business data is found
    $business_name = "Sarah Crane Crochet";
    $business_description = "Lorem ipsum dolor amet, consectetur adipiscing elit.";
    $instagram = "#";
    $facebook = "#";
    $tiktok = "#";
    $pinterest = "#";
    $website = "#";
}

// Handle form submission for updating business details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data for business details
    if (isset($_POST['business_name']) && isset($_POST['business_description'])) {
        $business_name = filter_input(INPUT_POST, 'business_name', FILTER_SANITIZE_STRING);
        $business_description = filter_input(INPUT_POST, 'business_description', FILTER_SANITIZE_STRING);

        // Create update query for business details
        $query = sprintf(
            "UPDATE businesses SET display_name='%s', description='%s' WHERE id='%d'",
            $business_name,
            $business_description,
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
        .sub-sidebar {
            background-color: #ddd2f1; 
            min-height: calc(100vh - 56px - 53px);
            padding: 10px;
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
            <div class="col-2 sub-sidebar">
                <div class="text-center">
                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto" style="width:80px; height:80px;">
                        <i class="bi bi-person fs-1"></i>
                    </div>
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


    <script>
        function editField(fieldId) {
            var field = document.getElementById(fieldId);
            var currentText = field.innerText || field.textContent;
            var newText = prompt("Edit this field", currentText);
            if (newText !== null) {
                field.innerText = newText;
            }
        }
    </script>
</body>
</html>

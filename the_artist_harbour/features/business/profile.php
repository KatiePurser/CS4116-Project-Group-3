<?php
session_start();
// Include the necessary files (for database connection, etc.)
include_once __DIR__ . '/../../utilities/databaseHandler.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /the_artist_harbour/features/registration-login/login.php");
    exit();
}

// Check if the user is not business account
if ($_SESSION['user_type'] !== 'business') {
    exit();
}

// Assign the user ID from the session
$user_id = $_SESSION["user_id"];

// Look up the business ID associated with this user
$query = "SELECT id FROM businesses WHERE user_id = $user_id";
$result = DatabaseHandler::make_select_query($query);

// Assign the correct business ID

if (!empty($result)) {
    $business_id = $result[0]['id'];

} else {
    die("No business found for this user. Please ensure your business profile is set up.");
}

if ($business_id) {
    $query = "SELECT * FROM businesses WHERE id = $business_id";
    $businessData = DatabaseHandler::make_select_query($query);
}


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




// Fetch services for the business
$queryServices = "SELECT id, name, description, min_price, max_price FROM services WHERE business_id = $business_id";
$services = DatabaseHandler::make_select_query($queryServices);

// Fetch recent reviews for the business with reviewer's name and rating
$query = "SELECT r.text, r.rating, r.created_at, u.first_name, u.last_name 
                 FROM reviews r
                 JOIN users u ON r.reviewer_id = u.id
                 WHERE r.business_id = $business_id
                 ORDER BY r.created_at DESC
                 LIMIT 3";  // Adjust limit as needed
$reviews = DatabaseHandler::make_select_query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Business Profile - The Artist Harbour</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;/
        }

        .container-fluid {
            padding: 0;
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

        .subheader h2 {
            padding: 10px;
            font-weight: bold;
            font-size: 1.5rem;
            color: #49375a;
            margin: 0;
        }


        .main-content {
            padding: 20px;
        }

        .profile-section {
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .profile-section h2 {
            color: #49375a;
            margin-top: 0;
        }

        .profile-section p {
            color: #555;
        }

        .services-section {
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .services-section h3 {
            color: #49375a;
            margin-top: 0;
        }

        .service-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .service-item:last-child {
            border-bottom: none;
        }

        .service-details h4 {
            color: #666;
            margin-top: 0;
            margin-bottom: 5px;
        }

        .service-details p {
            color: #777;
            margin-bottom: 0;
        }

        .service-price {
            font-weight: bold;
            color: #555;
        }

        .button {
            background-color: #82689A;
            color: white;
            border: none;
            padding: 8px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9em;
        }

        .reviews-section {
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
        }

        .reviews-section h3 {
            color: #49375a;
            margin-top: 0;
        }

        .review-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .review-item:last-child {
            border-bottom: none;
        }

        .review-item strong {
            color: #666;
        }

        .review-item p {
            color: #777;
            margin-top: 5px;
            margin-bottom: 0;
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


        <div class="col-9 main-content">
            <div class="profile-section">
                <h2>Business Information</h2>
                <p><?php echo htmlspecialchars($business_description); ?></p>
            </div>

            <div class="services-section">
                <h3>Services</h3>
                <?php if ($services && count($services) > 0): ?>
                    <?php foreach ($services as $service): ?>
                        <div class="service-item">
                            <div class="service-details">
                                <h4><?php echo htmlspecialchars($service['name']); ?></h4>
                                <p><?php echo htmlspecialchars($service['description']); ?></p>
                            </div>
                            <div class="service-price">
                                €<?php
                                if (isset($service['min_price']) && $service['min_price'] !== null && isset($service['max_price']) && $service['max_price'] !== null) {
                                    echo htmlspecialchars($service['min_price']) . "-€" . htmlspecialchars($service['max_price']);
                                } elseif (isset($service['max_price']) && $service['max_price'] !== null) {
                                    echo htmlspecialchars($service['max_price']);
                                } else {
                                    echo "Contact for price";
                                }
                                ?>
                            </div>
                            <button class="button">Request</button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No services offered yet.</p>
                <?php endif; ?>
            </div>

            <div class="reviews-section">
                <h3>Recent Reviews</h3>
                <?php if ($reviews && count($reviews) > 0): ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-item">
                            <strong><?php echo htmlspecialchars($review['first_name'] . " " . $review['last_name']); ?>:</strong>
                            <p><?php echo htmlspecialchars($review['text']); ?></p>
                            <p><strong>Rating:</strong> <?php echo number_format($review['rating'], 1); ?> / 5</p>
                            <p><em>Reviewed on: <?php echo date("F j, Y", strtotime($review['created_at'])); ?></em></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No reviews yet.</p>
                <?php endif; ?>
            </div>

        </div>
    </div>
    </div>
</body>

</html>
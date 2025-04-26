<?php
session_start();
// Include the necessary files (for database connection, etc.)
include_once __DIR__ . '/../../utilities/databaseHandler.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /CS4116-Project-Group-3/the_artist_harbour/features/registration-login/login.php");
    exit();
}

// Determine the business ID to display
$business_id = null;
$is_own_profile = false;

// Check if a specific business ID is provided in the URL (using business_id parameter)
if (isset($_GET['business_id'])) {
    // Case 1: Any user viewing a specific business profile by ID
    $business_id = intval($_GET['business_id']);

    // Check if this is the business owner viewing their own profile
    if ($_SESSION['user_type'] === 'business') {
        // Get the business ID associated with the logged-in user
        $query = "SELECT id FROM businesses WHERE user_id = {$_SESSION['user_id']}";
        $result = DatabaseHandler::make_select_query($query);

        if (!empty($result) && $result[0]['id'] == $business_id) {
            $is_own_profile = true;
        }
    }
} else if ($_SESSION['user_type'] === 'business') {
    // Case 2: Business user accessing profile.php without an ID parameter
    // Redirect to their own profile with the ID
    $query = "SELECT id FROM businesses WHERE user_id = {$_SESSION['user_id']}";
    $result = DatabaseHandler::make_select_query($query);

    if (!empty($result)) {
        $business_id = $result[0]['id'];
        header("Location: profile.php?business_id=$business_id");
        exit();
    } else {
        die("No business found for this user. Please ensure your business profile is set up.");
    }
} else {
    // Case 3: Non-business user accessing profile.php without an ID parameter
    // Redirect to home page
    header("Location: /CS4116-Project-Group-3/the_artist_harbour/public/home_page.php");
    exit();
}

// Get the user_id associated with this business
$query = "SELECT user_id FROM businesses WHERE id = $business_id";
$result = DatabaseHandler::make_select_query($query);

if (!empty($result)) {
    $user_id = $result[0]['user_id'];
} else {
    die("Business not found.");
}

// Now fetch the business details

if ($business_id) {
    $query = "SELECT b.display_name, b.description, b.instagram, b.facebook, b.tiktok, b.pinterest, b.website, u.first_name, u.last_name 
          FROM businesses b 
          JOIN users u ON b.user_id = u.id 
          WHERE b.id = $business_id";
    $businessDetails = DatabaseHandler::make_select_query($query);

    if ($businessDetails && count($businessDetails) > 0) {
        $business_name = $businessDetails[0]['display_name'];
        $business_description = $businessDetails[0]['description'];
        $owner_first_name = $businessDetails[0]['first_name'];
        $owner_last_name = $businessDetails[0]['last_name'];
        $profile_pic_src = "/../user/get_image.php?id=$user_id";

        // Social media links
        $instagram = $businessDetails[0]['instagram'];
        $facebook = $businessDetails[0]['facebook'];
        $tiktok = $businessDetails[0]['tiktok'];
        $pinterest = $businessDetails[0]['pinterest'];
        $website = $businessDetails[0]['website'];
    } else {
        // fallback defaults
        $business_name = "Your Business Name";
        $business_description = "Business bio goes here.";
        $owner_first_name = "First";
        $owner_last_name = "Last";
        $profile_pic_src = "../../public/images/user_icon.svg";
        $instagram = $facebook = $tiktok = $pinterest = $website = "";
    }
}

// Pagination for services
$services_per_page = 6;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $services_per_page;

// Fetch services for the business with pagination
$queryServices = "SELECT id, name, description, tags, min_price, max_price, image FROM services 
                 WHERE business_id = $business_id 
                 ORDER BY created_at DESC 
                 LIMIT $offset, $services_per_page";
$services = DatabaseHandler::make_select_query($queryServices);

// Get total number of services for pagination
$queryTotalServices = "SELECT COUNT(*) as total FROM services WHERE business_id = $business_id";
$totalServicesResult = DatabaseHandler::make_select_query($queryTotalServices);
$total_services = $totalServicesResult[0]['total'] ?? 0;
$total_pages = ceil($total_services / $services_per_page);


// Fetch reviews and calculate average rating
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$sort_clause = '';

switch ($sort_by) {
    case 'highest':
        $sort_clause = 'ORDER BY r.rating DESC, r.created_at DESC';
        break;
    case 'lowest':
        $sort_clause = 'ORDER BY r.rating ASC, r.created_at DESC';
        break;
    case 'newest':
    default:
        $sort_clause = 'ORDER BY r.created_at DESC';
        break;
}

// First get all service IDs for this business
$queryServiceIds = "SELECT id FROM services WHERE business_id = $business_id";
$serviceIds = DatabaseHandler::make_select_query($queryServiceIds);

// Initialize variables
$total_reviews = 0;
$avg_rating = 0;
$reviews = [];
$total_review_pages = 1;

// If there are services, create an array of their IDs
if ($serviceIds && count($serviceIds) > 0) {
    $serviceIdList = array_map(function ($item) {
        return $item['id'];
    }, $serviceIds);

    $serviceIdString = implode(',', $serviceIdList);

    // Set up pagination
    $reviews_per_page = 5;
    $review_page = isset($_GET['review_page']) ? (int) $_GET['review_page'] : 1;
    $review_offset = ($review_page - 1) * $reviews_per_page;

    // Count total reviews
    $queryReviewsCount = "SELECT COUNT(*) as total FROM reviews WHERE service_id IN ($serviceIdString)";
    $reviewsCount = DatabaseHandler::make_select_query($queryReviewsCount);
    $total_reviews = $reviewsCount[0]['total'] ?? 0;
    $total_review_pages = ceil($total_reviews / $reviews_per_page);

    // Calculate average rating
    $queryAvgRating = "SELECT AVG(rating) as avg_rating FROM reviews WHERE service_id IN ($serviceIdString)";
    $avgRating = DatabaseHandler::make_select_query($queryAvgRating);
    $avg_rating = $avgRating[0]['avg_rating'] ?? 0;


    // Fetch reviews with service names
    if ($total_reviews > 0) {
        $query = "SELECT r.id, r.text, r.rating, r.created_at, r.service_id, u.first_name, u.last_name, s.name as service_name
            FROM reviews r
            JOIN users u ON r.reviewer_id = u.id
            JOIN services s ON r.service_id = s.id
            WHERE r.service_id IN ($serviceIdString)
            $sort_clause
            LIMIT $review_offset, $reviews_per_page";
        $reviews = DatabaseHandler::make_select_query($query);
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($business_name); ?> - The Artist Harbour</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            overflow-x: hidden;
        }

        /* Center container with responsive padding */
        .center-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px;
        }

        /* Medium screens */
        @media (min-width: 768px) {
            .center-container {
                padding: 80px;
            }
        }

        /* Large screens */
        @media (min-width: 992px) {
            .center-container {
                padding: 100px;
            }
        }

        /* Extra large screens */
        @media (min-width: 1400px) {
            .center-container {
                max-width: 1320px;
                padding: 100px;
            }
        }

        /* Small screens */
        @media (max-width: 576px) {
            .center-container {
                padding: 40px;
            }
        }

        /* Main layout containers */
        .business-profile-container {
            display: flex;
            min-height: calc(100vh - 73.6px);
        }

        .sidebar-container {
            position: fixed;
            width: 4%;
            height: 100vh;
            z-index: 1000;
            background-color: #9074a8;
        }

        .content-container {
            margin-left: 4%;
            width: 96%;
            overflow-y: auto;
            padding-top: 20px;
        }

        .main-content {
            margin-top: 20px;
            padding: 20px;
            margin-left: auto;
            margin-right: auto;
        }

        .content-wrapper {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            padding: 30px;
        }

        /* Profile Section */
        .profile-section {
            position: relative;
            margin-bottom: 30px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        }

        .cover-photo {
            height: 180px;
            background-color: #82689A;
            background-image: linear-gradient(135deg, #82689A 0%, #49375a 100%);
            position: relative;
        }

        .profile-content {
            background-color: #f8f8f8;
            border: 1px solid #e0d8f3;
            border-top: none;
            padding: 25px;
            position: relative;
        }

        .profile-img-container {
            margin-top: -80px;
            position: relative;
            z-index: 10;
        }

        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #fff;
            box-shadow: 0 2px 8px rgba(130, 104, 154, 0.2);
            background-color: #fff;
        }

        .profile-info {
            padding-top: 10px;
        }

        .profile-info h2 {
            color: #49375a;
            margin-top: 0;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .profile-info p {
            color: #555;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .social-links a {
            color: #82689A;
            font-size: 1.5rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f0ebf7;
        }

        .social-links a:hover {
            color: #fff;
            background-color: #82689A;
            transform: translateY(-3px);
        }

        .rating-summary {
            display: flex;
            align-items: center;
            margin-top: 10px;
            background-color: #f0ebf7;
            padding: 8px 15px;
            border-radius: 20px;
            display: inline-flex;
        }

        .stars {
            color: #82689A;
            margin-right: 10px;
            font-size: 1.1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .profile-img-container {
                margin-top: -70px;
                margin-bottom: 15px;
            }

            .profile-img {
                width: 120px;
                height: 120px;
            }

            .profile-info {
                text-align: center;
            }

            .social-links {
                justify-content: center;
                margin-top: 20px;
            }

            .rating-summary {
                justify-content: center;
                margin: 15px auto;
                display: inline-flex;
            }
        }

        .stars {
            color: #82689A;
            margin-right: 10px;
        }

        /* Services Section */
        .section-title {
            color: #49375a;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0d8f3;
        }

        .services-section {
            margin-bottom: 30px;
        }

        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .service-item {
            border: 1px solid #e0d8f3;
            border-radius: 12px;
            background-color: #fdfcff;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .service-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(130, 104, 154, 0.15);
        }

        .service-image {
            height: 180px;
            background-color: #f0f0f0;
            overflow: hidden;
        }

        .service-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .service-details {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .service-details h4 {
            color: #4a3b5c;
            margin-top: 0;
            margin-bottom: 10px;
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
        }

        .service-price {
            font-weight: bold;
            color: #4a2c5d;
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
        }

        .request-btn {
            background-color: #82689A;
            color: white;
            border: none;
            padding: 8px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9em;
            transition: background-color 0.3s ease;
        }

        .request-btn:hover {
            background-color: #70578c;
            color: white;
        }

        .service-card-link {
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .service-card-link:hover {
            text-decoration: none;
            color: inherit;
        }

        /* Reviews Section */
        .reviews-section {
            margin-bottom: 30px;
        }

        .reviews-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .sort-options {
            display: flex;
            gap: 10px;
        }

        .sort-btn {
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            color: #333;
        }

        .sort-btn.active {
            background-color: #e0d8f3;
            border-color: #82689A;
            color: #49375a;
        }

        .review-item {
            padding: 20px;
            border: 1px solid #e0d8f3;
            border-radius: 12px;
            background-color: #fcfbfe;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(130, 104, 154, 0.1);
            transition: box-shadow 0.2s ease;
        }

        .review-item:hover {
            box-shadow: 0 4px 10px rgba(130, 104, 154, 0.15);
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .reviewer-info {
            font-weight: bold;
            color: #4a3b5c;
        }

        .review-rating {
            color: #82689A;
        }

        .review-content {
            color: #666;
            margin: 10px 0;
        }

        .review-date {
            color: #999;
            font-size: 0.9em;
            text-align: right;
        }

        .service-reviewed-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            border-bottom: 1px solid #e0d8f3;
            padding-bottom: 10px;
        }

        .service-reviewed-header h4 {
            color: #49375a;
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .review-actions {
            display: flex;
            gap: 10px;
        }

        .flag-review-btn {
            color: #dc3545;
            border-color: #dc3545;
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .flag-review-btn:hover {
            background-color: #dc3545;
            color: white;
        }

        .insight-request-btn {
            color: #82689A;
            border-color: #82689A;
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .insight-request-btn:hover {
            background-color: #82689A;
            color: white;
        }

        .btn-outline-purple {
            color: #82689A;
            border-color: #82689A;
        }

        .btn-outline-purple:hover {
            background-color: #82689A;
            color: white;
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination a {
            display: block;
            padding: 5px 10px;
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #e0d8f3;
        }

        .pagination a.active {
            background-color: #82689A;
            color: white;
            border-color: #70578c;
        }

        /* Additional responsive adjustments */
        @media (max-width: 768px) {
            .profile-img-container {
                position: relative;
                top: -80px;
                left: 50%;
                transform: translateX(-50%);
                margin-bottom: -60px;
            }

            .profile-info {
                margin-left: 0;
                text-align: center;
            }

            .social-links {
                justify-content: center;
            }

            .reviews-header {
                flex-direction: column;
                gap: 10px;
            }

            .sort-options {
                width: 100%;
                justify-content: space-between;
            }
        }

        @media (max-width: 576px) {
            .service-grid {
                grid-template-columns: 1fr;
            }

            .content-wrapper {
                padding: 15px;
            }
        }

        /* Additional styles for the modals */
        .modal-content {
            background-color: #f5f0ff;
            /* Light purple background for modal body */
            border: none;
            border-radius: 12px;
        }

        .modal-header {
            background-color: #82689A;
            /* Dark purple background for modal header */
            color: white;
            /* White text for better contrast */
            border-bottom: 1px solid #70578c;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            padding: 15px 20px;
        }

        .modal-title {
            color: white;
            font-weight: 600;
        }

        .modal-footer {
            border-top: 1px solid #e0d8f3;
            background-color: #f5f0ff;
            /* Light purple background for modal footer */
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        .modal-body {
            padding: 20px;
        }

        /* Style for the close button in the header */
        .modal-header .btn-close {
            color: white;
            opacity: 0.8;
            filter: brightness(0) invert(1);
            /* Make the close button white */
        }

        .modal-header .btn-close:hover {
            opacity: 1;
        }

        /* Style for primary buttons in modals */
        .modal .btn-primary {
            background-color: #82689A;
            border-color: #70578c;
        }

        .modal .btn-primary:hover {
            background-color: #70578c;
            border-color: #5f4a7b;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div>
        <?php include __DIR__ . '/../../templates/header.php'; ?>
    </div>

    <!-- Center Container -->
    <div class="center-container">
        <!-- Business Profile Container -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body p-4">
                <div class="row">
                    <!-- Profile Image Column -->
                    <div class="col-md-3 text-center mb-3 mb-md-0">
                        <?php if ($user_id): ?>
                            <img src="../user/get_image.php?id=<?php echo $user_id; ?>" alt="Profile Picture"
                                class="rounded-circle img-fluid profile-img">
                        <?php else: ?>
                            <img src="../../public/images/user_icon.svg" alt="Default Profile"
                                class="rounded-circle img-fluid profile-img">
                        <?php endif; ?>
                    </div>

                    <!-- Profile Info Column -->
                    <div class="col-md-9">
                        <h2 class="card-title text-purple"><?php echo htmlspecialchars($business_name); ?></h2>
                        <p class="text-muted mb-2">Owned by
                            <?php echo htmlspecialchars($owner_first_name . ' ' . $owner_last_name); ?></p>

                        <!-- Business Description -->
                        <div class="mb-3">
                            <p><?php echo htmlspecialchars($business_description); ?></p>
                        </div>

                        <!-- Rating Summary -->
                        <?php if ($total_reviews > 0): ?>
                            <div class="mb-3">
                                <div class="d-inline-block bg-light-purple rounded-pill px-3 py-2">
                                    <div class="d-flex align-items-center">
                                        <div class="stars me-2">
                                            <?php
                                            $full_stars = floor($avg_rating);
                                            $half_star = $avg_rating - $full_stars >= 0.5;
                                            $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);

                                            for ($i = 0; $i < $full_stars; $i++) {
                                                echo '<i class="bi bi-star-fill"></i>';
                                            }

                                            if ($half_star) {
                                                echo '<i class="bi bi-star-half"></i>';
                                            }

                                            for ($i = 0; $i < $empty_stars; $i++) {
                                                echo '<i class="bi bi-star"></i>';
                                            }
                                            ?>
                                        </div>
                                        <span><?php echo number_format($avg_rating, 1); ?> out of 5
                                            (<?php echo $total_reviews; ?> reviews)</span>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Social Media Links -->
                        <div class="social-links">
                            <?php if (!empty($instagram) && $instagram !== '#'): ?>
                                <a href="<?php echo htmlspecialchars($instagram); ?>" target="_blank" title="Instagram">
                                    <i class="bi bi-instagram"></i>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($facebook) && $facebook !== '#'): ?>
                                <a href="<?php echo htmlspecialchars($facebook); ?>" target="_blank" title="Facebook">
                                    <i class="bi bi-facebook"></i>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($tiktok) && $tiktok !== '#'): ?>
                                <a href="<?php echo htmlspecialchars($tiktok); ?>" target="_blank" title="TikTok">
                                    <i class="bi bi-tiktok"></i>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($pinterest) && $pinterest !== '#'): ?>
                                <a href="<?php echo htmlspecialchars($pinterest); ?>" target="_blank" title="Pinterest">
                                    <i class="bi bi-pinterest"></i>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($website) && $website !== '#'): ?>
                                <a href="<?php echo htmlspecialchars($website); ?>" target="_blank" title="Website">
                                    <i class="bi bi-globe"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services Section -->
        <?php include __DIR__ . '/../service/service_request_modal.php'; ?>
        <script src="../../features/service/js/handle_service_request.js"></script>
        <div class="services-section">
            <h3 class="section-title">Services</h3>

            <?php if ($services && count($services) > 0): ?>
                <div class="service-grid">
                    <?php foreach ($services as $service): ?>
                        <a href="/CS4116-Project-Group-3/the_artist_harbour/features/service/service.php?service_id=<?= $service['id'] ?>"
                            class="service-card-link">
                            <div class="service-item">
                                <div class="service-image">
                                    <?php if (!empty($service['image'])): ?>
                                        <img src="./get_serviceImage.php?id=<?= $service['id'] ?>"
                                            alt="<?php echo htmlspecialchars($service['name']); ?>">
                                    <?php else: ?>
                                        <img src="../../public/images/default-service.png" alt="Default Service Image">
                                    <?php endif; ?>
                                </div>
                                <div class="service-details">
                                    <h4><?php echo htmlspecialchars($service['name']); ?></h4>

                                    <?php if (!empty($service['tags'])): ?>
                                        <div class="service-tags">
                                            <?php
                                            $tags = explode(',', $service['tags']);
                                            foreach ($tags as $tag):
                                                if (trim($tag) !== ''):
                                                    ?>
                                                    <span class="tag"><?php echo htmlspecialchars(trim($tag)); ?></span>
                                                    <?php
                                                endif;
                                            endforeach;
                                            ?>
                                        </div>
                                    <?php endif; ?>

                                    <p><?php echo htmlspecialchars($service['description']); ?></p>

                                    <div class="service-meta">
                                        <div class="service-price">
                                            <?php
                                            if (isset($service['min_price']) && $service['min_price'] !== null && isset($service['max_price']) && $service['max_price'] !== null) {
                                                echo '€' . htmlspecialchars($service['min_price']) . " - €" . htmlspecialchars($service['max_price']);
                                            } elseif (isset($service['max_price']) && $service['max_price'] !== null) {
                                                echo '€' . htmlspecialchars($service['max_price']);
                                            } else {
                                                echo "Contact for price";
                                            }
                                            ?>
                                        </div>
                                        <?php if (!$is_own_profile): // Only show request button if not the owner ?>
    <button type="button" class="button" 
            data-bs-toggle="modal" 
            data-bs-target="#serviceRequestModal" 
            data-service-id="<?= $service['id'] ?>" 
            data-price-final="<?= isset($service['max_price']) ? $service['max_price'] : '' ?>"
            onclick="event.preventDefault(); event.stopPropagation();">
        Request
    </button>
<?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination for Services -->
                <?php if ($total_pages > 1): ?>
                    <div class="pagination-container">
                        <ul class="pagination">
                            <?php if ($page > 1): ?>
                                <li><a href="?page=<?php echo $page - 1; ?>">&laquo; Previous</a></li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li>
                                    <a href="?page=<?php echo $i; ?>" <?php echo $i === $page ? 'class="active"' : ''; ?>>
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $total_pages): ?>
                                <li><a href="?page=<?php echo $page + 1; ?>">Next &raquo;</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <p>No services offered yet.</p>
            <?php endif; ?>
        </div>


        <!-- Reviews Section -->
        <div class="reviews-section">
            <div class="reviews-header">
                <h3 class="section-title">Customer Reviews</h3>

                <?php if ($total_reviews > 0): ?>
                    <div class="sort-options">
                        <a href="?business_id=<?php echo $business_id; ?>&sort=newest"
                            class="sort-btn <?php echo $sort_by === 'newest' ? 'active' : ''; ?>">
                            Newest
                        </a>
                        <a href="?business_id=<?php echo $business_id; ?>&sort=highest"
                            class="sort-btn <?php echo $sort_by === 'highest' ? 'active' : ''; ?>">
                            Highest Rating
                        </a>
                        <a href="?business_id=<?php echo $business_id; ?>&sort=lowest"
                            class="sort-btn <?php echo $sort_by === 'lowest' ? 'active' : ''; ?>">
                            Lowest Rating
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($reviews && count($reviews) > 0): ?>
                <?php foreach ($reviews as $review): 
                    $id = $review['id'];
                    $sql = "SELECT * FROM review_replies WHERE review_id=$id";
                    $reply_exists = DatabaseHandler::make_select_query($sql);?>
                    <div class="review-item">
                        <!-- Service name at the top in bigger text -->
                        <div class="service-reviewed-header">
                            <h4><?php echo htmlspecialchars($review['service_name']); ?></h4>

                            <div class="review-actions">
                                <!-- Flag button for inappropriate reviews -->
                                <button type="button" class="btn btn-sm btn-outline-danger flag-review-btn"
                                    data-bs-toggle="modal" data-bs-target="#flagReviewModal"
                                    data-review-id="<?php echo $review['id']; ?>">
                                    <i class="bi bi-flag"></i> Flag
                                </button>

                                <!-- Insight Request button for customers only -->
                                <?php if ($_SESSION['user_type'] === 'customer'): ?>
                                    <button type="button" class="btn btn-sm btn-outline-purple insight-request-btn"
                                        data-bs-toggle="modal" data-bs-target="#insightRequestModal"
                                        data-service-id="<?php echo $review['service_id']; ?>"
                                        data-business-id="<?php echo $business_id; ?>">
                                        <i class="bi bi-lightbulb"></i> Request Insight
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="review-header">
                            <div class="reviewer-info">
                                <?php echo htmlspecialchars($review['first_name'] . " " . $review['last_name']); ?>
                            </div>
                            <div class="review-rating">
                                <?php
                                $rating = $review['rating'];
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $rating) {
                                        echo '<i class="bi bi-star-fill"></i>';
                                    } elseif ($i - 0.5 <= $rating) {
                                        echo '<i class="bi bi-star-half"></i>';
                                    } else {
                                        echo '<i class="bi bi-star"></i>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="review-content">
                            <?php echo htmlspecialchars($review['text']); ?>
                        </div>
                        <div class="review-date">
                            <em>Reviewed on: <?php echo date("F j, Y", strtotime($review['created_at'])); ?></em>
                        </div>
                        <div class="review-reply">
                            <!-- Review Reply Button for Businesses only -->
                            <?php if ($_SESSION['user_type'] === 'business' && $reply_exists == NULL) { ?>
                                <form id="responseForm" method="POST" action="../review/submit_review_reply.php">
                                    <input type="hidden" name="review_id" id="reviewId" value="<?php echo $review['id']?>">
                                    <input type="hidden" name="page" id="page" value="service">
                                    <input type="hidden" name="service_id" id="service_id" value="<?php echo $service_id ?>">
                                
                                    <div class="mb-4">
                                        <label for="reviewResponseText" class="form-label fw-semibold">Your Response</label>
                                        <textarea class="form-control rounded-3 border" id="reviewResponseText" name="review_response_text" rows="4"
                                            placeholder="Type your response here..." required></textarea>
                                    </div>
                                
                                    <div class="modal-footer d-flex justify-content-between border-0 px-0">
                                        <button type="submit" class="submit-btn btn text-white px-4">Submit Response</button>
                                    </div>
                                </form>
                            <?php } else if ($reply_exists) { ?>
                                <div class="review-reply-content">
                                    <div class="replied">
                                        <?php echo htmlspecialchars("Reply from Business:"); ?>
                                    </div>
                                    <div class="reply-text">
                                        <?php echo htmlspecialchars($reply_exists[0]['text']); ?>
                                    </div>
                                    <div class="review-date">
                                        <em>Replied on: <?php echo date("F j, Y", strtotime($reply_exists[0]['created_at'])); ?></em>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php endforeach; ?>


                <!-- Pagination for Reviews -->
                <?php if ($total_review_pages > 1): ?>
                    <div class="pagination-container">
                        <ul class="pagination">
                            <?php if ($review_page > 1): ?>
                                <li><a
                                        href="?business_id=<?php echo $business_id; ?>&review_page=<?php echo $review_page - 1; ?>&sort=<?php echo $sort_by; ?>">&laquo;
                                        Previous</a></li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_review_pages; $i++): ?>
                                <li>
                                    <a href="?business_id=<?php echo $business_id; ?>&review_page=<?php echo $i; ?>&sort=<?php echo $sort_by; ?>"
                                        <?php echo $i === $review_page ? 'class="active"' : ''; ?>>
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($review_page < $total_review_pages): ?>
                                <li><a
                                        href="?business_id=<?php echo $business_id; ?>&review_page=<?php echo $review_page + 1; ?>&sort=<?php echo $sort_by; ?>">Next
                                        &raquo;</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <p>No reviews yet.</p>
            <?php endif; ?>
        </div>

        <!-- Flag Review Modal -->
        <div class="modal fade" id="flagReviewModal" tabindex="-1" aria-labelledby="flagReviewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="flagReviewModalLabel">Flag Inappropriate Review</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="flagReviewForm" action="../reviews/flag_review.php" method="post">
                        <div class="modal-body">
                            <input type="hidden" id="review_id" name="review_id">
                            <div class="mb-3">
                                <label for="flag_reason" class="form-label">Reason for flagging:</label>
                                <select class="form-select" id="flag_reason" name="flag_reason" required>
                                    <option value="">Select a reason</option>
                                    <option value="inappropriate">Inappropriate content</option>
                                    <option value="spam">Spam</option>
                                    <option value="offensive">Offensive language</option>
                                    <option value="false">False information</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="flag_details" class="form-label">Additional details (optional):</label>
                                <textarea class="form-control" id="flag_details" name="flag_details"
                                    rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Flag Review</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Insight Request Modal -->
        <?php if ($_SESSION['user_type'] === 'customer'): ?>
            <div class="modal fade" id="insightRequestModal" tabindex="-1" aria-labelledby="insightRequestModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="insightRequestModalLabel">Request Insight</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="insightRequestForm" action="../messages/scripts/insight_request.php" method="post">
                            <div class="modal-body">
                                <input type="hidden" id="service_id" name="service_id">
                                <input type="hidden" id="business_id" name="business_id">
                                <p>Request more information about this service from the business owner.</p>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Your message:</label>
                                    <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Send Request</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- JavaScript for handling modals -->
        <script>
            // Handle passing data to the flag review modal
            document.addEventListener('DOMContentLoaded', function () {
                const flagReviewModal = document.getElementById('flagReviewModal');
                if (flagReviewModal) {
                    flagReviewModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;
                        const reviewId = button.getAttribute('data-review-id');
                        document.getElementById('review_id').value = reviewId;
                    });
                }

                // Handle passing data to the insight request modal
                const insightRequestModal = document.getElementById('insightRequestModal');
                if (insightRequestModal) {
                    insightRequestModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;
                        const serviceId = button.getAttribute('data-service-id');
                        const businessId = button.getAttribute('data-business-id');
                        document.getElementById('service_id').value = serviceId;
                        document.getElementById('business_id').value = businessId;
                    });
                }
            });
        </script>


        <!-- JavaScript for handling pagination and sorting -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Handle pagination and sorting with URL parameters
                function updateURLParameter(url, param, paramVal) {
                    let newAdditionalURL = "";
                    let tempArray = url.split("?");
                    let baseURL = tempArray[0];
                    let additionalURL = tempArray[1];
                    let temp = "";

                    if (additionalURL) {
                        tempArray = additionalURL.split("&");
                        for (let i = 0; i < tempArray.length; i++) {
                            if (tempArray[i].split('=')[0] != param) {
                                newAdditionalURL += temp + tempArray[i];
                                temp = "&";
                            }
                        }
                    }

                    let rows_txt = temp + "" + param + "=" + paramVal;
                    return baseURL + "?" + newAdditionalURL + rows_txt;
                }

                // Update links to preserve all parameters
                document.querySelectorAll('.pagination a, .sort-btn').forEach(link => {
                    link.addEventListener('click', function (e) {
                        e.preventDefault();

                        let url = new URL(this.href);
                        let currentUrl = new URL(window.location.href);

                        // Get all parameters from current URL
                        for (let param of currentUrl.searchParams.keys()) {
                            // Skip the parameter that's in the clicked link
                            if (!url.searchParams.has(param) && param !== 'sort' && param !== 'review_page' && param !== 'page') {
                                url.searchParams.set(param, currentUrl.searchParams.get(param));
                            }
                        }

                        window.location.href = url.toString();
                    });
                });
            });
        </script>
</body>

</html>
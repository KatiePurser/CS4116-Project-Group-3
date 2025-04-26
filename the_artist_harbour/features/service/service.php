<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /CS4116-Project-Group-3/the_artist_harbour/features/registration-login/login.php");
    exit();
}

if ($_SESSION['user_type'] == 'admin') {
    exit();
}


require_once(__DIR__ . "/../../utilities/databaseHandler.php");
require_once(__DIR__ . "/serviceDetails.php"); 
require_once(__DIR__ . "/insight_request_modal.php");
require_once(__DIR__ . "/service_request_modal.php");
require_once(__DIR__ . "/review_report_modal.php");
    $service_id=$_GET["service_id"];
    $sql = "SELECT * FROM services WHERE id=$service_id";
    $result = DatabaseHandler::make_select_query($sql);
    $service = $result[0];
    $sql="SELECT * FROM businesses WHERE id={$service['business_id']}";
    $result = DatabaseHandler::make_select_query($sql);
    $business = $result[0];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $service['name'] ?></title>
        <link rel="stylesheet" href="../../public/css/styles.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/handle_insight_request.js"></script>
        <script src="js/handle_service_request.js"></script>
        <script src="js/handle_review_report.js"></script>
        <script src="js/outcome_handling.js"></script>

        <style>
            .information {
                max-height: 60%;
                margin-top: 2vh;
                margin-left: 2vw;
                margin-right:2vw;
                margin-bottom: 3vh;
            }

            .info-container {
                max-height: fit-content;
                border-radius: 2%;
                padding: 1%;
                padding-bottom: 3%;
                text-align:center;
            }

            .margin {
                max-height: fit-content;
            }

            .name-container {
                margin: auto;
                padding: 0.5%;
                margin-bottom: 2vh;
                background-color: #E2D4F0;
                border:5px solid #82689A;
                border-radius: 0.5vw;
            }

            .business-button {
                font-size: 20px;
                text-decoration: none;
                color: black;
            }

            .business-button:hover {
                color: hotpink;
            }

            .description-and-tags {
                border-radius: 0.5vw;
                background-color: #E2D4F0;
                border-width: 0.5%;
                padding-top: 1vh;
                padding-bottom: 0.2vh;
            }

            .description-container {
                margin: auto;
                padding: 0.5%;
                min-height: 10%;
            }

            .image-container {
                padding:1%;
                border: 10px solid #E2D4F0;
                max-height: fit-content;
                border-radius: 2%;
                justify-content: center;
            }

            .image {
                height: fit-content;
                max-height: 60%;
            } 

            .price {
                margin: auto;
                margin-top: 2vh;
                float: left;
                padding-left: 5vw;
                padding-right: 5vw;
                background-color: #E2D4F0;
                border-radius: 1vw;
            }

            .service-request-btn {
                float: right;
                margin-top: 2vh;
                color: white;
                background-color: #82689A; 
                border-width: 2%; 
                border-color: #82689A;
                border-radius: 1vw;
                font-size: 24;
                width: 30%;
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
        </style>
    </head>
    <body style="padding-top: 73.6px;">
        <div class="row g-0">
            <div class="col-12">
                <?php include __DIR__ . '/../../templates/header.php'; ?>
            </div>
        </div>

        <div class="row information g-0">
            <div class="col-6 g-0 info-container justify-content-center">
                <div class="name-container">
                    <h1 class="name"><?php echo $service['name'] ?></h1>
                    <?php
                    $url = "../business/profile.php?business_id=".$business['id'];
                    echo '<a class="business-button" href='.$url.'> from '. $business['display_name'] .'</a>'; ?>
                </div>
                <div class="description-and-tags">
                    <div class="description-container">
                        <h5 class="description-title">DESCRIPTION</h5>
                        <h5 class="description"><?php echo $service['description'] ?></h5>
                    </div>
                    <div class="tags-container">
                        <?php 
                        $tags_string="";
                        if($service['tags']!=NULL){
                            $tags_string=="Tags: ";
                            $tags=explode(",", $service['tags'], 25);
                            $i=0;
                            while($i<count($tags)){
                                $tags_string.=$tags[$i];
                                if($i!=count($tags)-1){
                                    $tags_string.= ", ";
                                }
                                $i++;
                            }
                        } else { 
                            $tags_string = "No Tags";
                        } ?>
                        <p class="tags"><?php echo $tags_string ?></p>
                    </div>
                </div>
                <div>
                    <div class="price-container">
                        <?php 
                        if($service['min_price']==NULL){ ?>
                            <h3 class="price"> <?php echo "€".$service['max_price']; ?> </h3>
                        <?php } else { ?>
                            <h3 class="price"> <?php echo "€".$service['min_price']." - €".$service['max_price']; ?></h3>
                        <?php }
                        ?>
                    </div>
                    <div class="service_request">
                        <?php if($_SESSION['user_type'] == 'customer') { 
                            if($service['min_price'] == NULL){
                                $min_price = '0';
                            } else {
                                $min_price = $service['min_price'];
                            }?>
                            <button type="button" class="btn service-request-btn p-0" data-bs-toggle="modal" data-bs-target="#serviceRequestModal"
                                data-price-min="<?php echo $min_price ?>" data-price-max="<?php echo $service['max_price']?>" 
                                data-service-id="<?php echo $service['id']?>" >
                                Request Service
                            </button>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-1 margin"></div>
            <div class="col-5 image-container">
                <?php
                if(!empty($service['image'])){ ?>
                    <img src="../business/get_serviceImage.php?id=<?= $service['id'] ?>" class="card-img-top image" alt="Service Image">
                <?php }else{?>
                    <img src="../../public/images/default-service.png" class="card-img-top image" alt="Default Image">
                <?php }
                ?>
            </div>
        </div>
        <br>

        <!-- Reviews -->
         <?php 
            $reviews_per_page = 5;
            $review_page = isset($_GET['review_page']) ? (int) $_GET['review_page'] : 1;
            $review_offset = ($review_page - 1) * $reviews_per_page;

            $sql="SELECT * FROM reviews WHERE service_id=$service_id";
            $num_reviews = count(DatabaseHandler::make_select_query($sql));
            $total_review_pages = ceil($num_reviews / $reviews_per_page);

            $sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

            if($num_reviews > 0){
                if ($sort_by == "newest"){
                    $sql.=" ORDER BY created_at DESC";
                } else if ($sort_by == "highest"){
                    $sql.=" ORDER BY rating DESC";
                } else if ($sort_by == "lowest"){
                    $sql.=" ORDER BY rating ASC";
                }
                $sql.=" LIMIT $review_offset, $reviews_per_page";
                $reviews = DatabaseHandler::make_select_query($sql);
            }
         ?>

        <div class="center-container">
            <div class="reviews-section">
                <div class="reviews-header">
                    <h2> REVIEWS </h2>

                    <?php if ($num_reviews > 0): ?>
                        <div class="sort-options">
                            <a href="?service_id=<?php echo $service_id; ?>&sort=newest"
                                class="sort-btn <?php echo $sort_by === 'newest' ? 'active' : ''; ?>">
                                Newest
                            </a>
                            <a href="?service_id=<?php echo $service_id; ?>&sort=highest"
                                class="sort-btn <?php echo $sort_by === 'highest' ? 'active' : ''; ?>">
                                Highest Rating
                            </a>
                            <a href="?service_id=<?php echo $service_id; ?>&sort=lowest"
                                class="sort-btn <?php echo $sort_by === 'lowest' ? 'active' : ''; ?>">
                                Lowest Rating
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if($reviews && count($reviews) > 0){ 
                    foreach ($reviews as $review){ ?>
                        <div class="review-item">
                            <div class="service-reviewed-header">
                                <div class="reviewer-info">
                                    <?php echo htmlspecialchars(ServiceDetails::getReviewer($review['reviewer_id'])); ?>
                                </div>

                                <div class="review-actions">
                                    <!-- Flag button for inappropriate reviews -->
                                    <button type="button" class="btn btn-sm btn-outline-danger flag-review-btn"
                                        data-bs-toggle="modal" data-bs-target="#reviewReportModal"
                                        data-review-id="<?php echo $review['id']; ?>" data-reported-id="<?php echo $review['reviewer_id']; ?>"
                                        data-service-id="<?php echo $service_id; ?>" data-review-content="<?php echo $review['text']; ?>"> 
                                        <i class="bi bi-flag"></i> Flag
                                    </button>

                                    <!-- Insight Request button for customers only -->
                                    <?php if ($_SESSION['user_type'] === 'customer'): ?>
                                        <button type="button" class="btn btn-sm btn-outline-purple insight-request-btn"
                                            data-bs-toggle="modal" data-bs-target="#insightRequestModal"
                                            data-service-id="<?php echo $review['service_id']; ?>"
                                            data-receiver-id="<?php echo $review['reviewer_id'];; ?>">
                                            <i class="bi bi-lightbulb"></i> Request Insight
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="review-header">
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
                        </div>
                    <?php } ?>

                    <!-- Pagination for Reviews -->
                    <?php if ($total_review_pages > 1): ?>
                        <div class="pagination-container">
                            <ul class="pagination">
                                <?php if ($review_page > 1): ?>
                                    <li><a
                                            href="?service_id=<?php echo $service_id; ?>&review_page=<?php echo $review_page - 1; ?>&sort=<?php echo $sort_by; ?>">&laquo;
                                            Previous</a></li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $total_review_pages; $i++): ?>
                                    <li>
                                        <a href="?service_id=<?php echo $service_id; ?>&review_page=<?php echo $i; ?>&sort=<?php echo $sort_by; ?>"
                                            <?php echo $i === $review_page ? 'class="active"' : ''; ?>>
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($review_page < $total_review_pages): ?>
                                    <li><a
                                            href="?service_id=<?php echo $service_id; ?>&review_page=<?php echo $review_page + 1; ?>&sort=<?php echo $sort_by; ?>">Next
                                            &raquo;</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?>               
                <?php } ?>
            </div>
        </div>
    </body>
</html>
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /CS4116-Project-Group-3/the_artist_harbour/features/registration-login/login.php");
    exit();
}

if ($_SESSION['user_type'] !== 'customer') {
    exit();
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>The Artist Harbour</title>
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="../features/search/search.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <script src="./../features/service/js/handle_service_request.js"></script>
        
        <style>

            body {
                /* font-family: sans-serif; */
                margin: 0;
                padding: 0;
                background-color: #fff;
                overflow-x: hidden;
            }

            .home-heading {
                text-align: center;
                max-width: fit-content;
                margin: 20px;
                margin-top: 10vh;
                margin-bottom: 0;
                padding-left: 2.5vw;
                padding-right: 2.5vw;
                background-color:#82689A;
                color: white;
                border: 2px dashed #E2D4F0;
                border-radius: 15px
            }

            .home-title {
                font-family: "Amarante", cursive;
                padding: 4vh;
            }

            .home-description {
                padding-bottom: 2vh;
            }

            .center-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 40px;
            }

            /* Medium screens */
            @media (min-width: 576px) {
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

            .services-section {
                margin-bottom: 30px;
            }

            .services-title {
                text-align: center;
                margin-bottom: 4vh;
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

            .service-rating {
                display: flex;
                justify-content: space-between;
            }

            .service-rating p {
                padding-left: 7px;
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

            @media (max-width: 576px) {
                .service-grid {
                    grid-template-columns: 1fr;
                }

                .content-wrapper {
                    padding: 15px;
                }
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

            .modal-header,
            .submit-btn {
                background-color: #82689A;
            }

            .submit-btn:hover {
                background-color: #5b496d;
            }

            .modal-title {
                padding: 10px;
            }

            .modal-header,
            .close-btn {
                background-color: #82689A;
            }

            .close-btn:hover {
                background-color: #5b496d;
            }
        </style>
    </head>
    <body style="padding-top: 73.6px;">
        <div>
            <?php include __DIR__ . '/../templates/header.php'; ?>
        </div>
        <div class="container-fluid">
            <div class="row g-0">
                <div class="col-12">
                    <?php 
                    if (!empty($_SESSION['error'])) {
                        echo("<div class='row mb-2 g-0'><div class='alert alert-danger'><span><i class='bi bi-exclamation-triangle'></span></i> {$_SESSION['error']} </div><div class='col-12'></div></div>");
                        unset($_SESSION['error']);
                    }?>
                </div>
            </div>

            <div class="row g-0">
                <div class="home-heading">
                    <h1 class="home-title">WELCOME TO THE ARTIST HARBOUR</h1>
                    <h3 class="home-description">We are a collective working to make a safe and community-based space for artists to market their bespoke services</h3>
                </div>
            </div>
        </div>

        <?php
            require_once(__DIR__ . "/../utilities/databaseHandler.php");
            require_once(__DIR__ . "/../features/service/serviceDetails.php");
            require_once(__DIR__ . "/../utilities/imageHandler.php");
            require_once(__DIR__ . "/../features/search/searchMethods.php");
            require_once(__DIR__ . "/../features/service/service_request_modal.php");


            $sql = "SELECT * FROM services ORDER BY reviews DESC LIMIT 12";
            $services = DatabaseHandler::make_select_query($sql);
            $businesses = DatabaseHandler::make_select_query("SELECT id, display_name FROM businesses "); ?>
            <div class="center-container">
                <div class="services-section">
                    <h2 class="services-title">OUR TOP-RATED SERVICES</h2>
                    <div class="service-grid">
                        <?php foreach ($services as $service){ ?>
                        <a href="../features/service/service.php?service_id=<?= $service['id'] ?>" class="service-card-link">
                            <div class="service-item">
                                <div class="service-image">
                                    <?php if (!empty($service['image'])){ ?>
                                        <img src="../features/business/get_serviceImage.php?id=<?= $service['id'] ?>" alt="<?php echo htmlspecialchars($service['name']); ?>">
                                    <?php }else{ ?>
                                        <img src="images/default-service.png" alt="Default Service Image">
                                    <?php } ?>
                                </div>
                                <div class="service-details" style="padding: 15px;">
                                    <h4><?php echo htmlspecialchars($service['name']); ?></h4>
                                    <p><?php echo htmlspecialchars(searchMethods::getBusinessName($businesses, $service['business_id'])); ?></p>
                                    <?php if (!empty($service['tags'])){ ?>
                                        <div class="service-tags">
                                            <?php
                                            $tags = explode(',', $service['tags']);
                                            foreach ($tags as $tag){
                                                if (trim($tag) !== ''){
                                                    ?>
                                                    <span class="tag"><?php echo htmlspecialchars(trim($tag)); ?></span>
                                                    <?php
                                                };
                                            };
                                            ?>
                                        </div>
                                    <?php }; ?>
                                    <div class="service-rating">
                                        <?php
                                        $rating = $service['reviews'];
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $rating) {
                                                echo '<i class="bi bi-star-fill"></i>';
                                            } elseif ($i - 0.5 <= $rating) {
                                                echo '<i class="bi bi-star-half"></i>';
                                            } else {
                                                echo '<i class="bi bi-star"></i>';
                                            }
                                        }?>
                                        <p> <?php echo ServiceDetails::getRating($service['reviews']) ?> </p>
                                    </div>
                                    <div class="service-meta">
                                        <div class="service-price">
                                            <?php
                                            if ($service['min_price'] !== null && $service['max_price'] !== null) {
                                                echo '€' . htmlspecialchars($service['min_price']) . " - €" . htmlspecialchars($service['max_price']);
                                            } elseif ($service['max_price'] !== null) {
                                                echo '€' . htmlspecialchars($service['max_price']);
                                            } else {
                                                echo "Contact for price";
                                            }
                                            ?>
                                        </div>
                                        <?php if ($_SESSION['user_type'] != 'business'){ // Only show request button if not the owner 
                                            if($service['min_price'] == NULL){
                                                $min_price = '0';
                                            } else {
                                                $min_price = $service['min_price'];
                                            }
                                            $service_id = $service['id'];
                                            $max_price = $service['max_price'];
                                            ?>
                                            <button type="button" class="btn service-request-btn p-0" data-bs-toggle="modal" data-bs-target="#serviceRequestModal"
                                                data-price-min="<?php echo $min_price;?>" data-price-max="<?php echo $max_price;?>" 
                                                data-service-id="<?php echo $service_id;?>" onclick="event.preventDefault(); event.stopPropagation();">
                                                Request
                                            </button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <!-- Service Request Modal -->
            <div id="serviceRequestModal" class="modal fade" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content shadow-lg rounded-4">
                        <div class="modal-header text-white rounded-top-4">
                            <h5 class="modal-title" id="serviceRequestModalLabel">Request Service</h5>
                            <button class="btn-close btn-close-white me-2" data-bs-dismiss="modal" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body px-5 py-4">
                            <form action="/CS4116-Project-Group-3/the_artist_harbour/features/service/submit_service_request.php" method="get">
                                <!-- hidden inputs -->
                                <input type="hidden" name="sender_id" id="sender_id" value="<?php echo $_SESSION['user_id'];?>">
                                <input type="hidden" name="price_min" id="priceMin">
                                <input type="hidden" name="price_max" id="priceMax">
                                <input type="hidden" name="service_id" id="serviceId">

                                <div class="mb-4">
                                    <label for="message" class="form-label fw-semibold">Message</label>
                                    <textarea class="form-control rounded-3 border" id="message" name="message" rows="4"
                                        placeholder="Please add any extra details or requests here..." required></textarea>
                                </div>

                                <div class="modal-footer d-flex justify-content-between border-0 px-0">
                                    <button type="button" class="btn btn-outline-secondary px-4"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="submit-btn btn px-4">Send Service Request</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Service Request Script -->
            <script>
                var serviceRequestModal = document.getElementById('serviceRequestModal')

                serviceRequestModal.addEventListener('show.bs.modal', function (event) {
                    // Get the button that triggered the modal
                    var button = event.relatedTarget;

                    // Extract data attributes from the button (message ID and reported user ID)
                    var priceMin = button.getAttribute('data-price-min');
                    var priceMax = button.getAttribute('data-price-max');
                    var serviceId = button.getAttribute('data-service-id');

                    var modalPriceMin = serviceRequestModal.querySelector('#priceMin');
                    var modalPriceMax = serviceRequestModal.querySelector('#priceMax');
                    var modalServiceId = serviceRequestModal.querySelector('#serviceId');
                    
                    modalPriceMin.value = priceMin;
                    modalPriceMax.value = priceMax;
                    modalServiceId.value = serviceId;
                    
                });
            </script>   
               
    </body>
</html>
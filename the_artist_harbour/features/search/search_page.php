<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /CS4116-Project-Group-3/the_artist_harbour/features/registration-login/login.php");
    exit();
}

if ($_SESSION['user_type'] != 'customer') {
    exit();
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Search Results</title>
        <link rel="stylesheet" href="../../public/css/styles.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- <script src="./../service/js/handle_service_request.js"></script> -->
        
        <style>
            
            body {
                font-family: sans-serif;
                margin: 0;
                padding: 0;
                background-color: #fff;
                overflow-x: hidden;
                padding-top: 73.6px;
            }

            .filter-container {
                background-color: #E2D4F0; 
                text-align: center;
                border-bottom: 2px dashed #82689A;
            }

            .filter-title {
                padding: 0.5%;
                border: 2px dashed #82689A;
                max-width: fit-content;
                margin: auto;
                margin-bottom: 0.5%;
                margin-top: 0.5%;
                border-radius: 5px;
            }

            .price-range {
                display: flex;
                justify-content: center;
                align-items: center;
                margin-top: auto;
            }
            
            .min-price {
                padding: 1vw;
            }

            .max-price {
                padding: 1vw;
            }

            .tags-title {
                font-size: 20px;
                padding-top: 2vh;
            }

            .tags-container {
                margin-left: 5%;
                margin-right: 5%;

            }

            .tag-label {
                padding-left: 1vw;
            }

            .filter_buttons {
                background-color: #82689A;
                color: white;
                border: 1px solid #82689A;
                border-radius: 5px;
                margin-bottom: 2vh;
            }

            .keyword-desc {
                padding: 0;
                padding-left: 1vw;
            }

            .center-container {
                max-width: 1200px;
                margin: 0 auto;
                padding:40px;
                padding-top: 10px;
            }

            /* Medium screens */
            @media (min-width: 576px) {
                .center-container {
                    padding: 80px;
                    padding-top: 10px;
                }
            }

            /* Large screens */
            @media (min-width: 992px) {
                .center-container {
                    padding: 100px;
                    padding-top: 10px;
                }
            }

            /* Extra large screens */
            @media (min-width: 1400px) {
                .center-container {
                    max-width: 1320px;
                    padding: 100px;
                    padding-top: 10px;
                }
            }

            /* Small screens */
            @media (max-width: 576px) {
                .center-container {
                    padding: 40px;
                    padding-top: 10px;
                }

                .service-grid {
                    grid-template-columns: 1fr;
                }

                .content-wrapper {
                    padding: 15px;
                }
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

            .businesses-title {
                text-align: center;
                padding-top: 20px;
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


    <body>

        <?php 
            require_once __DIR__ . '/../../utilities/InputValidationHelper.php';
            // require_once __DIR__ . '/../service/service_request_modal.php';

            try{
                if(!isset($_GET['search'])){
                    $keyword=$_POST['search'];
                }else{
                    $keyword=$_GET["search"];
                }
                $search = InputValidationHelper::validateSearch("Search", $keyword, 0, 30);
            }catch (InvalidArgumentException $exception) {
                $_SESSION['error'] = $exception->getMessage();
                header("Location: ../../public/home_page.php");
                exit();
            }
            
            //check whether the customer requested to clear selections
            if(isset($_POST['clear'])){
                unset($_GET['min_price']);
                unset($_GET['max_price']);
                unset($_GET['rating']);
                unset($_GET['filter']);
                unset($_GET['tags']);
            }
        ?>

        <div>
            <?php include __DIR__ . '/../../templates/header.php'; ?>
        </div>

        <?php 
            require_once(__DIR__ . "/../../utilities/databaseHandler.php");
            require_once(__DIR__ . "/../service/serviceDetails.php"); 
            require_once(__DIR__ . "/../../utilities/imageHandler.php");
            require_once(__DIR__ . "/searchMethods.php");


            $csv = __DIR__ . "/../../utilities/tags.csv";
            $tags = SearchMethods::read($csv);
            ?>

            <!-- form for applying filters -->
            <div class="row g-0 filter-container" style="background-color: #E2D4F0; text-align: center;">
                <h3 class="filter-title">Filter Services</h3>
                <form action="search_page.php" method="post">
                    <input type="hidden" id="search" name="search" value=<?php echo $keyword?>>
                </form>
                <form action="search_page.php" method="get">
                    <input type="hidden" id="search" name="search" value=<?php echo $keyword?>>
                    <!-- apply a price range -->
                    <div class="price-range">
                        <div class="min-price">
                            <label for="min_price">Minimum Price:</label>
                            <input type="number" name="min_price" id="min_price" value="<?php if (isset($_GET['min_price'])) echo "{$_GET['min_price']}";?>">
                        </div>
                        <div class="max-price">
                            <label for="max_price">Maximum Price:</label>
                            <input type="number" name="max_price" id="max_price" value="<?php if (isset($_GET['max_price'])) echo "{$_GET['max_price']}";?>">
                        </div>
                    </div>
                    <!-- apply a desired rating -->
                    <select class="rating" name="rating" id="rating">
                        <option value="" disabled <?php if ((!isset($_GET['rating'])) || ((isset($_GET['rating']) && $_GET['rating']=="6"))) echo "selected";?> hidden>Filter By Reviews</option>
                        <option value="0" <?php if (isset($_GET['rating']) && $_GET['rating']=="0") echo "selected";?>>0 Stars</option>
                        <option value="1" <?php if (isset($_GET['rating']) && $_GET['rating']=="1") echo "selected";?>>1 Star</option>
                        <option value="2" <?php if (isset($_GET['rating']) && $_GET['rating']=="2") echo "selected";?>>2 Stars</option>
                        <option value="3" <?php if (isset($_GET['rating']) && $_GET['rating']=="3") echo "selected";?>>3 Stars</option>
                        <option value="4" <?php if (isset($_GET['rating']) && $_GET['rating']=="4") echo "selected";?>>4 Stars</option>
                        <option value="5" <?php if (isset($_GET['rating']) && $_GET['rating']=="5") echo "selected";?>>5 Stars</option>
                        <option value="6">Remove Selection</option>
                    </select>
                    <!-- apply an ordering method -->
                    <select class="filter" name="filter" id="filter">
                        <option value="" disabled <?php if ((!isset($_GET['filter'])) || ((isset($_GET['filter']) && $_GET['filter']=="5"))) echo "selected";?> hidden>Sort Services</option>
                        <option value="1" <?php if (isset($_GET['filter']) && $_GET['filter']=="1") echo "selected";?>>By Reviews (High to Low)</option>
                        <option value="2" <?php if (isset($_GET['filter']) && $_GET['filter']=="2") echo "selected";?>>By Reviews (Low to High)</option>
                        <option value="3" <?php if (isset($_GET['filter']) && $_GET['filter']=="3") echo "selected";?>>By Price (High to Low)</option>
                        <option value="4" <?php if (isset($_GET['filter']) && $_GET['filter']=="4") echo "selected";?>>By Price (Low to High)</option>
                        <option value="5">Remove Selection</option>
                    </select><br>
                    <!-- checkboxes for applying tags -->
                    <label class="tags-title" for="tags">Filter by Tags:</label><br>
                    <div id="tags" class="tags-container">
                        <?php 
                        $i=0;
                        $j=0;
                        if(isset($_GET['tags'])){
                            $tags_array = array_keys($_GET['tags']);
                            $count=count($tags_array);
                        }
                        while ($i < count($tags)) { 
                            $tag = $tags[$i][0];?>
                            <label class="tag-label">
                                <input class="tag-checkbox" type="checkbox" name="tags[<?php echo $i ?>]" value="<?php echo $tag ?>" 
                                <?php if(isset($_GET['tags'])){
                                    if($j<$count){
                                        if($tags_array[$j]==$i){ 
                                            echo " checked ";
                                            $j++;
                                        }
                                    }
                                }?>><?php echo $tag ?>
                            </label>
                            <?php $i++;
                        }
                        ?>
                    </div>
                    <br>
                    <input class="filter_buttons" type="submit" value="Set Filters">
                </form>
                <br>
                <form action="search_page.php" method="post">
                    <input type="hidden" id="search" name="search" value=<?php echo $keyword?>>
                    <input type="hidden" id="page" name="page" value="1">
                    <input class="filter_buttons" type="submit" name="clear" value="Clear Filters">
                </form>
            </div>

            <?php
            //SEARCH SERVICES BY KEYWORD

            $sql = "SELECT * FROM services WHERE name LIKE '%{$keyword}%'";
            $description = "Keyword=\"{$keyword}\"; ";

            //add a price min, max or range to the query
            if(isset($_GET['min_price'])){               
                if($_GET['min_price']!="" && $_GET['max_price']!=""){
                    //Any services within the given range
                    $min_price = $_GET['min_price'];
                    $max_price = $_GET['max_price'];
                    $sql.=" AND (min_price>=$min_price OR min_price IS NULL) AND max_price<=$max_price AND max_price>=$min_price";
                }else if($_GET['min_price']!=""){
                    //Any services more than given figure
                    $min_price = $_GET['min_price'];
                    $sql.=" AND (min_price>=$min_price OR min_price IS NULL) AND max_price>= $min_price";
                }else if($_GET['max_price']!=""){
                    //Any services less than given figure
                    $max_price = $_GET['max_price'];
                    $sql.=" AND max_price<=$max_price";
                }
            }
            
            //add a rating range to the query
            if(isset($_GET['rating'])){
                if($_GET['rating']==0){
                    //0 Stars
                    $sql.=" AND (reviews>=0.0 AND reviews<1.0)";
                }else if($_GET['rating']==1){
                    //1 Star
                    $sql.=" AND (reviews>=1.0 AND reviews<2.0)";
                }else if($_GET['rating']==2){
                    //2 Stars
                    $sql.=" AND (reviews>=2.0 AND reviews<3.0)";
                }else if($_GET['rating']==3){
                    //3 Stars
                    $sql.=" AND (reviews>=3.0 AND reviews<4.0)";
                }else if($_GET['rating']==4){
                    //4 Stars
                    $sql.=" AND (reviews>=4.0 AND reviews<5.0)";
                }else if($_GET['rating']==5){
                    //5 Stars
                    $sql.=" AND reviews=5.0";
                }
            }

            //query for chosen tags
            $i=0;
            if(isset($_GET['tags'])){
                $sql.=" AND (";
                $tags_array = array_keys($_GET['tags']);
                while($i<count($tags_array)){
                    $tag = $_GET['tags'][$tags_array[$i]];
                    $sql.=" (tags LIKE '%,{$tag},%' OR tags LIKE '{$tag},%' OR tags LIKE '%,{$tag}' OR tags LIKE '{$tag}')";
                    if($i<count($tags_array)-1){
                        $sql.=" OR";
                    }
                    $i++;
                }
                $sql.=")";
            }

            //applying a chosen ordering method to the query
            if(isset($_GET['filter'])){
                if($_GET['filter']==1){
                    //By Reviews (High to Low)
                    $sql.=" ORDER BY reviews DESC";
                }else if($_GET['filter']==2){
                    //By Reviews (Low to High)
                    $sql.=" ORDER BY reviews ASC";
                }else if($_GET['filter']==3){
                    //By Price (High to Low)
                    $sql.=" ORDER BY max_price DESC";
                }else if($_GET['filter']==4){
                    //By Price (Low to High)
                    $sql.=" ORDER BY max_price ASC";
                }
            } 
            ?>

            <div class="keyword-desc">
                <p>Searching by keyword: <i><?php echo "\"".$keyword."\""?></i></p>
            </div>

            <?php
            // Set variables
            $cards_per_page = 15;
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $offset = ($page - 1) * $cards_per_page;

            // Retrieve the necessary information from the DB
            $numServices = count(DatabaseHandler::make_select_query($sql));

            $sql.=" LIMIT $offset, $cards_per_page";

            $services = DatabaseHandler::make_select_query($sql);

            $total_service_pages = ceil($numServices / $cards_per_page);
            
            $businesses = DatabaseHandler::make_select_query("SELECT id, display_name FROM businesses ");
            ?>

            <div class="center-container">
                <div class="services-section">
                    <h1 style="text-align: center;"> SERVICES </h1>
                    <?php
                    if($services == NULL) {
                        ?> <h3 style="text-align: center;">NO SERVICES MATCH THE KEYWORD</h3> <br><br><br> <?php
                    } else { 
                    ?>
                    <div class="service-grid">
                        <?php foreach ($services as $service){ ?>
                        <a href="../service/service.php?service_id=<?= $service['id'] ?>" class="service-card-link">
                            <div class="service-item">
                                <div class="service-image">
                                    <?php if (!empty($service['image'])){ ?>
                                        <img src="../business/get_serviceImage.php?id=<?= $service['id'] ?>" alt="<?php echo htmlspecialchars($service['name']); ?>">
                                    <?php }else{ ?>
                                        <img src="../../public/images/default.png" alt="Default Service Image">
                                    <?php } ?>
                                </div>
                                <div class="service-details">
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
                                            <button type="button" class="btn request-btn p-0" data-bs-toggle="modal" data-bs-target="#serviceRequestModal"
                                                data-price-min="<?php echo $min_price ?>" data-price-max="<?php echo $service['max_price'] ?>" 
                                                data-service-id="<?php echo $service_id ?>" onclick="event.preventDefault(); event.stopPropagation();">
                                                Request 
                                            </button> 
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php } ?>
                    </div>

                    <?php if ($total_service_pages > 1){ ?>
                        <div class="pagination-container">
                            <ul class="pagination">
                                <?php if ($page > 1){ ?>
                                    <li><a href="?search=<?php echo $_GET['search']?>&page=<?php echo $page - 1; ?>">&laquo; Previous</a></li>
                                <?php } ?>

                                <?php for ($i = 1; $i <= $total_service_pages; $i++){ ?>
                                    <li>
                                        <a href="?search=<?php echo $_GET['search']?>&page=<?php echo $i; ?>" <?php echo $i === $page ? 'class="active"' : ''; ?>>
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php }; ?>

                                <?php if ($page < $total_service_pages){ ?>
                                    <li><a href="?search=<?php echo $_GET['search']?>&page=<?php echo $page + 1; ?>">Next &raquo;</a></li>
                                <?php }; ?>
                            </ul>
                        </div>
                    <?php }; ?>
                </div>
                <?php } 
                

            if(!isset($_GET['min_price']) && !isset($_GET['max_price']) && !isset($_GET['rating']) && !isset($_GET['tags']) && !isset($_GET['filter'])){
                //SEARCH BUSINESSES BY KEYWORD
                $sql = "SELECT * FROM businesses WHERE display_name LIKE '%{$keyword}%' ORDER BY reviews DESC";
                $result = DatabaseHandler::make_select_query($sql);
                $users = DatabaseHandler::make_select_query("SELECT id, profile_picture FROM users");
                $i=0; ?>
                <div class="services-section">
                    <h1 class="businesses-title"> BUSINESSES </h1>
                    <?php
                    if($result==NULL){
                        ?> <h3 style="text-align: center;">NO BUSINESSES MATCH THE KEYWORD</h3> <?php
                    }else{ 
                    ?>
                    <div class="service-grid">
                        <?php foreach ($result as $business){ ?>
                            <a href="../business/profile.php?business_id=<?= $business['id']?>" class="service-card-link">
                                <div class="service-item">
                                    <div class="service-image">
                                        <?php if(searchMethods::getProfileImage($users, $business['id'])==true){?>
                                            <img src="../user/get_image.php?id=<?= $business['id'] ?>" class="card-img-top image" style="height: 200px; object-fit: cover;">
                                        <?php }else{ ?>
                                            <img src="../../public/images/default.png" class="card-img-top image" alt="Default Image" style="max-height: 200px; object-fit: cover;">
                                        <?php } ?>
                                    </div>
                                    <div class="service-details">
                                        <h4><?php echo htmlspecialchars($business['display_name']); ?></h4>
                                        <p><?php echo ServiceDetails::getRating($business["reviews"]); ?></p>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                    <?php }?>
                </div>
                <?php } ?>
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
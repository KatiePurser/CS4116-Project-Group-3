<p?php
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
        <link rel="stylesheet" href="public/css/styles.css">
        <link rel="stylesheet" href="search.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- <style>
            div {
                padding: 0 !important;
            }
            
            /* .service_form {
                max-width: 23%;
                width: 23%;
                padding-left: 1vw;
                padding-right: 1vw;
                padding-bottom: 1vw;
            } */

            @media (max-width : 768px) {

                .card_button {
                    width: 98vw;
                    padding-left: 1vw;
                    padding-right: 1vw;
                    padding-bottom: 1vw;
                    border: none;
                    background-color: Transparent;
                }

                .hovercard {
                    width:100%;
                    height:100%;
                    word-wrap: break-word;
                    border-color: #82689A;
                    border-radius: 1vw;
                    border-width: 0.2vw;
                }

                .card-title {
                    display: block;
                    word-wrap: break-word;
                    max-width:100%;
                }

                .service_price {
                    background-color: #82689A;
                    border-radius: 0.5vw;
                    max-width: fit-content;
                    margin: auto;
                    padding-left: 0.5vw;
                    padding-right: 0.5vw;
                }
            }

            .card_button {
                width: 23vw;
                padding-left: 1vw;
                padding-right: 1vw;
                padding-bottom: 1vw;
                border: none;
                background-color: Transparent;
            }

            .hovercard {
                width:100%;
                height:100%;
                word-wrap: break-word;
                border-color: #82689A;
                border-radius: 1vw;
                border-width: 0.2vw;
            }

            .card-title {
                display: block;
                word-wrap: break-word;
                max-width:100%;
            }

            .service_price {
                background-color: #82689A;
                border-radius: 0.5vw;
                max-width: fit-content;
                margin: auto;
                padding-left: 0.5vw;
                padding-right: 0.5vw;
            }

            .filter_buttons{
                background-color: #82689A;
                border-radius: 0.5vw;
                font-size: 1.5vw;

            }
        </style> -->
    </head>
    <body style="padding-top: 73.6px;">

        <?php 
        require_once __DIR__ . '/../../utilities/InputValidationHelper.php';
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
        
        if(isset($_POST['clear'])){
            unset($_GET['min_price']);
            unset($_GET['max_price']);
            unset($_GET['rating']);
            unset($_GET['filter']);
            unset($_GET['tags']);
        }
        ?>

        <div class="container-fluid">
            <div class="row g-0">
                <div class="col-12">
                    <?php include __DIR__ . '/../../templates/header.php'; ?>
                </div>
            </div>
        <?php 
            require_once(__DIR__ . "/../../utilities/databaseHandler.php");
            require_once(__DIR__ . "/../service/serviceDetails.php"); 
            require_once(__DIR__ . "/../../utilities/imageHandler.php");
            require_once(__DIR__ . "/searchMethods.php");

            function read($csv){
                $file = fopen($csv, 'r');
                while (!feof($file) ) {
                    $line[] = fgetcsv($file, 1024);
                }
                fclose($file);
                return $line;
            }

            $csv = __DIR__ . "/../../utilities/tags.csv";
            $tags = read($csv);
            ?>

            <div class="row g-0" style="background-color: #E2D4F0; text-align: center;">
                <h3>Filter Services</h3>
                <form action="search_page.php" method="post">
                    <input type="hidden" id="search" name="search" value=<?php echo $keyword?>>
                </form>
                <form action="search_page.php" method="get">
                    <input type="hidden" id="search" name="search" value=<?php echo $keyword?>>
                    <label for="min_price">Minimum Price:</label>
                    <input type="number" name="min_price" id="min_price" value="<?php if (isset($_GET['min_price'])) echo "{$_GET['min_price']}";?>">
                    <label for="max_price">Maximum Price:</label>
                    <input type="number" name="max_price" id="max_price" value="<?php if (isset($_GET['max_price'])) echo "{$_GET['max_price']}";?>">
                    <select name="rating" id="rating">
                        <option value="" disabled <?php if (!isset($_GET['rating'])) echo "selected";?> hidden>Filter By Reviews</option>
                        <option value="0" <?php if (isset($_GET['rating']) && $_GET['rating']=="0") echo "selected";?>>0 Stars</option>
                        <option value="1" <?php if (isset($_GET['rating']) && $_GET['rating']=="1") echo "selected";?>>1 Star</option>
                        <option value="2" <?php if (isset($_GET['rating']) && $_GET['rating']=="2") echo "selected";?>>2 Stars</option>
                        <option value="3" <?php if (isset($_GET['rating']) && $_GET['rating']=="3") echo "selected";?>>3 Stars</option>
                        <option value="4" <?php if (isset($_GET['rating']) && $_GET['rating']=="4") echo "selected";?>>4 Stars</option>
                        <option value="5" <?php if (isset($_GET['rating']) && $_GET['rating']=="5") echo "selected";?>>5 Stars</option>
                    </select>
                    <select name="filter" id="filter">
                        <option value="" disabled <?php if (!isset($_GET['filter'])) echo "selected";?> hidden>Sort Services</option>
                        <option value="1" <?php if (isset($_GET['filter']) && $_GET['filter']=="1") echo "selected";?>>By Reviews (High to Low)</option>
                        <option value="2" <?php if (isset($_GET['filter']) && $_GET['filter']=="2") echo "selected";?>>By Reviews (Low to High)</option>
                        <option value="3" <?php if (isset($_GET['filter']) && $_GET['filter']=="3") echo "selected";?>>By Price (High to Low)</option>
                        <option value="4" <?php if (isset($_GET['filter']) && $_GET['filter']=="4") echo "selected";?>>By Price (Low to High)</option>
                    </select><br>
                    <label for="tags">Filter by Tags:</label><br>
                    <div class="dropdown">
                        <div id="tags" class="tags_div">
                            <?php 
                            $i=0;
                            $j=0;
                            if(isset($_GET['tags'])){
                                $tags_array = array_keys($_GET['tags']);
                                $count=count($tags_array);
                            }
                            while ($i < count($tags)) { 
                                $tag = $tags[$i][0];?>
                                <label class="tag_label"><input class="tag_checkbox" type="checkbox" name="tags[<?php echo $i ?>]" value="<?php echo $tag ?>" 
                                    <?php if(isset($_GET['tags'])){
                                        if($j<$count){
                                            if($tags_array[$j]==$i){ 
                                                echo " checked ";
                                                $j++;
                                            }
                                        }
                                    }?>><?php echo $tag ?></label>
                                <?php $i++;
                            }
                            ?>
                        </div>
                    </div>
                    <br>
                    <input class="filter_buttons" type="submit" value="Set Filters">
                    <br><br>
                </form>
                <form action="search_page.php" method="post">
                    <input type="hidden" id="search" name="search" value=<?php echo $keyword?>>
                    <input class="filter_buttons" type="submit" name="clear" value="Clear Filters">
                </form>
            </div>

            <?php
            //SEARCH SERVICES BY KEYWORD

            $sql = "SELECT * FROM services WHERE name LIKE '%{$keyword}%'";
            $description = "Keyword=\"{$keyword}\"; ";
            if(isset($_GET['min_price'])){               
                if($_GET['min_price']!="" && $_GET['max_price']!=""){
                    //Any services within the given range
                    $min_price = $_GET['min_price'];
                    $max_price = $_GET['max_price'];
                    $sql.=" AND (min_price>=$min_price OR min_price IS NULL) AND max_price<=$max_price AND max_price>=$min_price";
                    $description.= "Minimum Price=€{$min_price}; Maximum Price=€{$max_price};  ";
                }else if($_GET['min_price']!=""){
                    //Any services more than given figure
                    $min_price = $_GET['min_price'];
                    $sql.=" AND (min_price>=$min_price OR min_price IS NULL) AND max_price>= $min_price";
                    $description.= "Minimum Price=€{$min_price}; ";
                }else if($_GET['max_price']!=""){
                    //Any services less than given figure
                    $max_price = $_GET['max_price'];
                    $sql.=" AND max_price<=$max_price";
                    $description.= "Maximum Price=€{$max_price}; ";
                }
            }
            
            if(isset($_GET['rating'])){
                if($_GET['rating']==0){
                    //0 Stars
                    $sql.=" AND (reviews>=0.0 AND reviews<1.0)";
                    $description.= "Rating=0 Stars; ";
                }else if($_GET['rating']==1){
                    //1 Star
                    $sql.=" AND (reviews>=1.0 AND reviews<2.0)";
                    $description.= "Rating=1 Star; ";
                }else if($_GET['rating']==2){
                    //2 Stars
                    $sql.=" AND (reviews>=2.0 AND reviews<3.0)";
                    $description.= "Rating=2 Stars; ";
                }else if($_GET['rating']==3){
                    //3 Stars
                    $sql.=" AND (reviews>=3.0 AND reviews<4.0)";
                    $description.= "Rating=3 Stars; ";
                }else if($_GET['rating']==4){
                    //4 Stars
                    $sql.=" AND (reviews>=4.0 AND reviews<5.0)";
                    $description.= "Rating=4 Stars; ";
                }else if($_GET['rating']==5){
                    //5 Stars
                    $sql.=" AND reviews=5.0";
                    $description.= "Rating=5 Stars; ";
                }
            }

            $i=0;
            if(isset($_GET['tags'])){
                $description.="Tags=";
                $tags_array = array_keys($_GET['tags']);
                while($i<count($tags_array)){
                    $tag = $_GET['tags'][$tags_array[$i]];
                    $sql.=" AND (tags LIKE '%,{$tag},%' OR tags LIKE '{$tag},%' OR tags LIKE '%,{$tag}' OR tags LIKE '{$tag}')";
                    $i++;
                    $description.="{$tag} ";
                }
                $description.="; ";
            }

            if(isset($_GET['filter'])){
                if($_GET['filter']==1){
                    //By Reviews (High to Low)
                    $sql.=" ORDER BY reviews DESC;";
                    $description.="Order By=Reviews(High to Low); ";
                }else if($_GET['filter']==2){
                    //By Reviews (Low to High)
                    $sql.=" ORDER BY reviews ASC;";
                    $description.="Order By=Reviews(Low to High); ";
                }else if($_GET['filter']==3){
                    //By Price (High to Low)
                    $sql.=" ORDER BY max_price DESC;";
                    $description.="Order By=Price(High to Low); ";
                }else if($_GET['filter']==4){
                    //By Price (Low to High)
                    $sql.=" ORDER BY max_price ASC;";
                    $description.="Order By=Price(Low to High); ";
                }
            }


            $result = DatabaseHandler::make_select_query($sql);
            $i=0; 
            $businesses = DatabaseHandler::make_select_query("SELECT id, display_name FROM businesses ");?>
            <div>
                <p>Searching by keyword: <i><?php echo "\"".$keyword."\""?></i></p>
                <br>
            </div>
            <div class="justify-content-center">
                <h1 style="text-align: center;"> SERVICES </h1>
            </div> 
            <?php
            if($result == NULL){
                ?> <h3 style="text-align: center;">NO SERVICES MATCH THE KEYWORD</h3> <br><br><br> <?php
            }else{ 
                $service=$result[0];
                while($i<count($result)-4){ ?>
                <div>
                    <div class="card-group justify-content-center row">
                        <div class="col-sm-3">
                            <form class="card_form" action="../service/service.php" method="get">
                                <button class="card_button" type="submit">
                                    <input type="hidden" id="service_id" name="service_id" value=<?php echo $service["id"]?>>
                                    <div class="card hovercard text-center">
                                        <?php if (!empty($service['image'])){ ?>
                                            <img src="../business/get_serviceImage.php?id=<?= $service['id'] ?>" class="card-img-top" alt="Service Image" style="height: 200px; object-fit: cover;">
                                        <?php }else{ ?>
                                            <img src="../../public/images/default-service.png" class="card-img-top" alt="Default Image" style="height: 200px; object-fit: cover;">
                                        <?php } ?>
                                        <div class="card-body">
                                            <h3   class="card-title"><?php echo $service["name"]; ?></h3>
                                            </form>
                                            <form action="../business/profile.php" method="get">
                                                <input type="hidden" id="business_id" name="business_id" value="<?php echo $service['business_id']?>">
                                                <input type="submit" value="<?php echo searchMethods::getBusinessName($businesses, $service['business_id'])?>">
                                            </form>
                                            <form class="card_form" action="../service/service.php" method="get">
                                            <p><?php if(isset($service['tags'])){
                                                    echo "Tags: ".searchMethods::formatTags($service['tags']);
                                                }else{
                                                    echo "No tags";
                                                }?></p>
                                            <h4 class="card-subtitle service_price"><?php echo ServiceDetails::getServicePrice($service['min_price'], $service['max_price'])."\n"; ?></h4>
                                            <p class="card-text"><?php $rating = ServiceDetails::getRating($service["reviews"]); 
                                            echo $rating;?></p>
                                        </div>
                                    </div>
                                </button>
                            </form>
                        </div>
                        <?php $service = next($result); 
                        $i++;?>
                        <div class="col-sm-3">
                            <form class="card_form" action="../service/service.php" method="get">
                                <button class="card_button" type="submit">
                                    <input type="hidden" id="service_id" name="service_id" value=<?php echo $service["id"]?>>
                                    <div class="card hovercard text-center">
                                        <?php if (!empty($service['image'])){ ?>
                                            <img src="../business/get_serviceImage.php?id=<?= $service['id'] ?>" class="card-img-top" alt="Service Image" style="height: 200px; object-fit: cover;">
                                        <?php }else{ ?>
                                            <img src="../../public/images/default-service.png" class="card-img-top" alt="Default Image" style="height: 200px; object-fit: cover;">
                                        <?php } ?>
                                        <div class="card-body">
                                            <h3 class="card-title"><?php echo $service["name"]; ?></h3>
                                            </form>
                                            <form action="../business/profile.php" method="get">
                                                <input type="hidden" id="business_id" name="business_id" value="<?php echo $service['business_id']?>">
                                                <input type="submit" value="<?php echo searchMethods::getBusinessName($businesses, $service['business_id'])?>">
                                            </form>
                                            <form class="card_form" action="../service/service.php" method="get">
                                            <p><?php if(isset($service['tags'])){
                                                    echo "Tags: ".searchMethods::formatTags($service['tags']);
                                                }else{
                                                    echo "No tags";
                                                }?></p>
                                            <h4 class="card-subtitle service_price"><?php echo ServiceDetails::getServicePrice($service['min_price'], $service['max_price'])."\n"; ?></h4>
                                            <p class="card-text"><?php $rating = ServiceDetails::getRating($service["reviews"]); 
                                            echo $rating;?></p>
                                        </div>
                                    </div>
                                </button>
                            </form>
                        </div>
                        <?php $service = next($result); 
                        $i++;?>
                        <div class="col-sm-3">
                            <form class="card_form" action="../service/service.php" method="get">
                                <button class="card_button" type="submit">
                                    <input type="hidden" id="service_id" name="service_id" value=<?php echo $service["id"]?>>
                                    <div class="card hovercard text-center">
                                        <?php if (!empty($service['image'])){ ?>
                                            <img src="../business/get_serviceImage.php?id=<?= $service['id'] ?>" class="card-img-top" alt="Service Image" style="height: 200px; object-fit: cover;">
                                        <?php }else{ ?>
                                            <img src="../../public/images/default-service.png" class="card-img-top" alt="Default Image" style="height: 200px; object-fit: cover;">
                                        <?php } ?>
                                        <div class="card-body">
                                            <h3 class="card-title"><?php echo $service["name"]; ?></h3>
                                            </form>
                                            <form action="../business/profile.php" method="get">
                                                <input type="hidden" id="business_id" name="business_id" value="<?php echo $service['business_id']?>">
                                                <input type="submit" value="<?php echo searchMethods::getBusinessName($businesses, $service['business_id'])?>">
                                            </form>
                                            <form class="card_form" action="../service/service.php" method="get">
                                            <p><?php if(isset($service['tags'])){
                                                    echo "Tags: ".searchMethods::formatTags($service['tags']);
                                                }else{
                                                    echo "No tags";
                                                }?></p>
                                            <h4 class="card-subtitle service_price"><?php echo ServiceDetails::getServicePrice($service['min_price'], $service['max_price'])."\n"; ?></h4>
                                            <p class="card-text"><?php $rating = ServiceDetails::getRating($service["reviews"]); 
                                            echo $rating;?></p>
                                        </div>
                                    </div>
                                </button>
                            </form>
                        </div>
                        <?php $service = next($result); 
                        $i++;?>
                        <div class="col-sm-3">
                            <form class="card_form" action="../service/service.php" method="get">
                                <button class="card_button" type="submit">
                                    <input type="hidden" id="service_id" name="service_id" value=<?php echo $service["id"]?>>
                                    <div class="card hovercard text-center">
                                        <?php if (!empty($service['image'])){ ?>
                                            <img src="../business/get_serviceImage.php?id=<?= $service['id'] ?>" class="card-img-top" alt="Service Image" style="height: 200px; object-fit: cover;">
                                        <?php }else{ ?>
                                            <img src="../../public/images/default-service.png" class="card-img-top" alt="Default Image" style="height: 200px; object-fit: cover;">
                                        <?php } ?>
                                        <div class="card-body">
                                            <h3 class="card-title"><?php echo $service["name"]; ?></h3>
                                            </form>
                                            <form action="../business/profile.php" method="get">
                                                <input type="hidden" id="business_id" name="business_id" value="<?php echo $service['business_id']?>">
                                                <input type="submit" value="<?php echo searchMethods::getBusinessName($businesses, $service['business_id'])?>">
                                            </form>
                                            <form class="card_form" action="../service/service.php" method="get">
                                            <p><?php if(isset($service['tags'])){
                                                    echo "Tags: ".searchMethods::formatTags($service['tags']);
                                                }else{
                                                    echo "No tags";
                                                }?></p>
                                            <h4 class="card-subtitle service_price"><?php echo ServiceDetails::getServicePrice($service['min_price'], $service['max_price'])."\n"; ?></h4>
                                            <p class="card-text"><?php $rating = ServiceDetails::getRating($service["reviews"]); 
                                            echo $rating;?></p>
                                        </div>
                                    </div>
                                </button>
                            </form>
                        </div>
                        <?php $service = next($result); 
                        $i++;?>
                    </div>
                </div>
                <?php } ?>
                <div class="row g-0">
                    <div class="card-group justify-content-center">
                        <?php while($i<count($result)){ ?>
                            <form class="card_form" action="../service/service.php" method="get">
                                <button class="card_button" type="submit">
                                    <input type="hidden" id="service_id" name="service_id" value=<?php echo $service["id"]?>>
                                    <div class="card hovercard text-center">
                                    <?php if (!empty($service['image'])){ ?>
                                        <img src="../business/get_serviceImage.php?id=<?= $service['id'] ?>" class="card-img-top" alt="Service Image" style="height: 200px; object-fit: cover;">
                                    <?php }else{ ?>
                                        <img src="../../public/images/default-service.png" class="card-img-top" alt="Default Image" style="max-height: 200px; object-fit: cover;">
                                    <?php } ?>
                                        <div class="card-body">
                                            <h3 class="card-title"><?php echo $service["name"]; ?></h3>
                                            </form>
                                            <form action="../business/profile.php" method="get">
                                                <input type="hidden" id="business_id" name="business_id" value="<?php echo $service['business_id']?>">
                                                <input type="submit" value="<?php echo searchMethods::getBusinessName($businesses, $service['business_id'])?>">
                                            </form>
                                            <form class="card_form" action="../service/service.php" method="get">
                                            <p><?php if(isset($service['tags'])){
                                                    echo "Tags: ".searchMethods::formatTags($service['tags']);
                                                }else{
                                                    echo "No tags";
                                                }?></p>
                                            <h4 class="card-subtitle service_price"><?php echo ServiceDetails::getServicePrice($service['min_price'], $service['max_price'])."\n"; ?> </h4>
                                            <p class="card-text"><?php $rating = ServiceDetails::getRating($service["reviews"]); 
                                            echo $rating;?></p>
                                            
                                        </div>
                                    </div>
                                </button>
                            </form>
                            <?php $service = next($result);  
                            $i++;?>
                        <?php } ?>
                    </div>
                </div>
                <br><br><br>
            <?php } 

            if(!isset($_GET['min_price']) && !isset($_GET['max_price']) && !isset($_GET['rating']) && !isset($_GET['tags']) && !isset($_GET['filter'])){
                //SEARCH BUSINESSES BY KEYWORD
                $sql = "SELECT * FROM businesses WHERE display_name LIKE '%{$keyword}%' ORDER BY reviews DESC";
                $result = DatabaseHandler::make_select_query($sql);
                $users = DatabaseHandler::make_select_query("SELECT id, profile_picture FROM users");
                $i=0; ?>
                <div>
                    <h1 style="text-align: center;"> BUSINESSES </h1>
                </div>
                <?php
                if($result==NULL){
                    ?> <h3 style="text-align: center;">NO BUSINESSES MATCH THE KEYWORD</h3> <?php
                }else{ 
                    $business=$result[0];
                    while($i<count($result)-4){ ?>
                    <div class="row g-0 justify-content-center">
                        <div class="card-group justify-content-center">
                            <form class="card_form" action="../business/profile.php" method="get">
                                <button class="card_button" type="submit">
                                    <input type="hidden" id="business_id" name="business_id" value=<?php echo $business["id"]?>>
                                    <div class="card hovercard text-center">
                                        <?php if(searchMethods::getProfileImage($users, $business['id'])==true){?>
                                            <img src="../user/get_image.php?id=<?= $business['id'] ?>" class="profile-picture" style="height: 200px; object-fit: cover;">
                                        <?php }else{ ?>
                                            <img src="../../public/images/default-service.png" class="card-img-top" alt="Default Image" style="max-height: 200px; object-fit: cover;">
                                        <?php } ?>
                                        <div class="card-body">
                                            <h3 class="card-title"><?php echo $business["display_name"]; ?></h3>
                                            <p class="card-text"><?php $rating = ServiceDetails::getRating($business["reviews"]); 
                                            echo $rating;?></p>
                                        </div>
                                    </div>
                                </button>
                            </form>
                            <?php $business = next($result); 
                            $i++;?>
                            <form class="card_form" action="../business/profile.php" method="get">
                                <button class="card_button" type="submit">
                                    <input type="hidden" id="business_id" name="business_id" value=<?php echo $business["id"]?>>
                                    <div class="card hovercard text-center">
                                        <img class="card-img-top" src="https://placecats.com/300/200">
                                        <div class="card-body">
                                            <h3 class="card-title"><?php echo $business["display_name"]; ?></h3>
                                            <p class="card-text"><?php $rating = ServiceDetails::getRating($business["reviews"]); 
                                            echo $rating;?></p>
                                        </div>
                                    </div>
                                </button>
                            </form>
                            <?php $business = next($result); 
                            $i++;?>
                            <form class="card_form" action="../business/profile.php" method="get">
                                <button class="card_button" type="submit">
                                    <input type="hidden" id="business_id" name="business_id" value=<?php echo $business["id"]?>>
                                    <div class="card hovercard text-center">
                                        <img class="card-img-top" src="https://placecats.com/300/200">
                                        <div class="card-body">
                                            <h3 class="card-title"><?php echo $business["display_name"]; ?></h3>
                                            <p class="card-text"><?php $rating = ServiceDetails::getRating($business["reviews"]); 
                                            echo $rating;?></p>
                                        </div>
                                    </div>
                                </button>
                            </form>
                            <?php $business = next($result); 
                            $i++;?>
                            <form class="card_form" action="../business/profile.php" method="get">
                                <button class="card_button" type="submit">
                                    <input type="hidden" id="business_id" name="business_id" value=<?php echo $business["id"]?>>
                                    <div class="card hovercard text-center">
                                        <img class="card-img-top" src="https://placecats.com/300/200">
                                        <div class="card-body">
                                            <h3 class="card-title"><?php echo $business["display_name"]; ?></h3>
                                            <p class="card-text"><?php $rating = ServiceDetails::getRating($business["reviews"]); 
                                            echo $rating;?></p>
                                        </div>
                                    </div>
                                </button>
                            </form>
                            <?php $business = next($result); 
                            $i++;?>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="row g-0">
                        <div class="card-group justify-content-center">
                            <?php while($i<count($result)){ ?>
                                <form class="card_form" action="../business/profile.php" method="get">
                                    <button class="card_button" type="submit">
                                        <input type="hidden" id="business_id" name="business_id" value=<?php echo $business["id"]?>>
                                        <div class="card hovercard text-center">
                                            <img class="card-img-top" src="https://placecats.com/300/200">
                                            <div class="card-body">
                                                <h3 class="card-title"><?php echo $business["display_name"]; ?></h3>
                                                <p class="card-text"><?php $rating = ServiceDetails::getRating($business["reviews"]); 
                                                echo $rating;?></p>
                                            </div>
                                        </div>
                                    </button>
                                </form>
                                <?php $business = next($result);  
                                $i++;?>
                            <?php } ?>
                        </div>
                    </div>
                <?php } 
            }?>
            
    </body>
</html>
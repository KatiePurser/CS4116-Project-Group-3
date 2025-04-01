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
        <link rel="stylesheet" href="public/css/styles.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <style>
            div {
                padding: 0 !important;
            }
        </style>
    </head>
    <body style="padding-top: 73.6px;">

<!-- NOTE: MAKE BUSINESS FORMS REDIRECT TO RIGHT PAGE -->
        <div class="container-fluid">
            <div class="row g-0">
                <div class="col-12">
                    <?php include __DIR__ . '/../../templates/header.php'; ?>
                </div>
            </div>
        <?php 
            require_once(__DIR__ . "/../../utilities/databaseHandler.php");
            require_once(__DIR__ . "/../service/serviceDetails.php"); 
            require_once(__DIR__ . "/searchMethods.php");

            function read($csv){
                $file = fopen($csv, 'r');
                while (!feof($file) ) {
                    $line[] = fgetcsv($file, 1024);
                }
                fclose($file);
                return $line;
            }
            
            $keyword=$_GET["search"];

            $csv = __DIR__ . "/../../utilities/tags.csv";
            $tags = read($csv);
            ?>

            <div class="row g-0">
                <div class="col-12">
                    <form action="search_page.php" method="get">
                        <input type="hidden" id="search" name="search" value=<?php echo $keyword?>>
                        <label for="min_price">Minimum Price:</label>
                        <input type="number" name="min_price" id="min_price">
                        <label for="max_price">Maximum Price:</label>
                        <input type="number" name="max_price" id="max_price">
                        <select name="rating" id="rating">
                            <option value="-1" selected>Filter By Reviews</option>
                            <option value="0">0 Stars</option>
                            <option value="1">1 Star</option>
                            <option value="2">2 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="5">5 Stars</option>
                        </select>
                        <select name="filter" id="filter">
                            <option value="-1" selected>Sort Services</option>
                            <option value="1">By Reviews (High to Low)</option>
                            <option value="2">By Reviews (Low to High)</option>
                            <option value="3">By Price (High to Low)</option>
                            <option value="4">By Price (Low to High)</option>
                        </select><br>
                        <label for="tags">Filter by Tags:</label><br>
                        <div class="dropdown">
                            <!-- <button onclick="myFunction()" class="dropbtn">Select Tags</button> -->
                            <div id="tags" class="tags_div">
                                <?php 
                                $i=0;
                                while ($i < count($tags)) { 
                                    $tag = $tags[$i][0];?>
                                    <label class="tag_label"><input class="tag_checkbox" type="checkbox" name="tags[<?php echo $i ?>]" value="<?php echo $tag ?>"><?php echo $tag ?></label>
                                    <?php $i++;
                                }
                                ?>
                            </div>
                        </div>
                        <input type="submit" value="Add Filters">
                    </form>
                </div>
            </div>

            <!-- <script>
                function myFunction() {
                    document.getElementById("tags").classList.toggle("show");
                }

                // Close the dropdown menu if the user clicks outside of it
                window.onclick = function(event) {
                if (!event.target.matches('.dropbtn')) {
                    var dropdowns = document.getElementsByClassName("tags_div");
                    var i;
                    for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                    }
                }
                }
            </script> -->

            <?php
            //SEARCH SERVICES BY KEYWORD

            $sql = "SELECT * FROM services WHERE name LIKE '%{$keyword}%'";
            $description = "Filtering By: Keyword=\"{$keyword}\"; ";
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
                if($_GET['rating']==-1){
                    //Default - do nothing
                }else if($_GET['rating']==0){
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
                if($_GET['filter']==-1){
                    //Default - do nothing
                }else if($_GET['filter']==1){
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
            $i=0; ?>
            <div>
                <br>
                <p><i><?php echo $description ?></i></p>
                <br><br><br>
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
                    <div class="card-group justify-content-center">
                        <form action="service.php" method="get">
                            <button type="submit">
                                <input type="hidden" id="service_id" name="service_id" value=<?php echo $service["id"]?>>
                                <div class="card hovercard text-center">
                                    <img class="card-img-top" src="https://placecats.com/300/200">
                                    <div class="card-body">
                                        <h3 class="card-title"><?php echo $service["name"]; ?></h3>
                                        <h4 class="card-subtitle"><?php echo ServiceDetails::getServicePrice($service['min_price'], $service['max_price'])."\n"; ?> </h4>
                                        <p class="card-text"><?php $rating = ServiceDetails::getRating($service["reviews"]); 
                                        echo $rating;?></p>
                                    </div>
                                </div>
                            </button>
                        </form>
                        <?php $service = next($result); 
                        $i++;?>
                        <form action="service.php" method="get">
                            <button type="submit">
                                <input type="hidden" id="service_id" name="service_id" value=<?php echo $service["id"]?>>
                                <div class="card hovercard text-center">
                                    <img class="card-img-top" src="https://placecats.com/300/200">
                                    <div class="card-body">
                                        <h3 class="card-title"><?php echo $service["name"]; ?></h3>
                                        <h4 class="card-subtitle"><?php echo ServiceDetails::getServicePrice($service['min_price'], $service['max_price'])."\n"; ?></h4>
                                        <p class="card-text"><?php $rating = ServiceDetails::getRating($service["reviews"]); 
                                        echo $rating;?></p>
                                    </div>
                                </div>
                            </button>
                        </form>
                        <?php $service = next($result); 
                        $i++;?>
                        <form action="service.php" method="get">
                            <button type="submit">
                                <input type="hidden" id="service_id" name="service_id" value=<?php echo $service["id"]?>>
                                <div class="card hovercard text-center">
                                    <img class="card-img-top" src="https://placecats.com/300/200">
                                    <div class="card-body">
                                        <h3 class="card-title"><?php echo $service["name"]; ?></h3>
                                        <h4 class="card-subtitle"><?php echo ServiceDetails::getServicePrice($service['min_price'], $service['max_price'])."\n"; ?></h4>
                                        <p class="card-text"><?php $rating = ServiceDetails::getRating($service["reviews"]); 
                                        echo $rating;?></p>
                                    </div>
                                </div>
                            </button>
                        </form>
                        <?php $service = next($result); 
                        $i++;?>
                        <form action="service.php" method="get">
                            <button type="submit">
                                <input type="hidden" id="service_id" name="service_id" value=<?php echo $service["id"]?>>
                                <div class="card hovercard text-center">
                                    <img class="card-img-top" src="https://placecats.com/300/200">
                                    <div class="card-body">
                                        <h3 class="card-title"><?php echo $service["name"]; ?></h3>
                                        <h4 class="card-subtitle"><?php echo ServiceDetails::getServicePrice($service['min_price'], $service['max_price'])."\n"; ?></h4>
                                        <p class="card-text"><?php $rating = ServiceDetails::getRating($service["reviews"]); 
                                        echo $rating;?></p>
                                    </div>
                                </div>
                            </button>
                        </form>
                        <?php $service = next($result); 
                        $i++;?>
                    </div>
                </div>
                <?php } ?>
                <div class="row g-0">
                    <div class="card-group justify-content-center">
                        <?php while($i<count($result)){ ?>
                            <form action="../service/service.php" method="get">
                                <button type="submit">
                                    <input type="hidden" id="service_id" name="service_id" value=<?php echo $service["id"]?>>
                                    <div class="card hovercard text-center">
                                        <img class="card-img-top" src="https://placecats.com/300/200">
                                        <div class="card-body">
                                            <h3 class="card-title"><?php echo $service["name"]; ?></h3>
                                            <h4 class="card-subtitle"><?php echo ServiceDetails::getServicePrice($service['min_price'], $service['max_price'])."\n"; ?> </h4>
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


            //SEARCH BUSINESSES BY KEYWORD
            $sql = "SELECT * FROM businesses WHERE display_name LIKE '%{$keyword}%' ORDER BY reviews DESC";
            $result = DatabaseHandler::make_select_query($sql);
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
                        <form action="../business/profile.php" method="get">
                            <button type="submit">
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
                        <form action="../business/profile.php" method="get">
                            <button type="submit">
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
                        <form action="../business/profile.php" method="get">
                            <button type="submit">
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
                        <form action="../business/profile.php" method="get">
                            <button type="submit">
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
                            <form action="../business/profile.php" method="get">
                                <button type="submit">
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
            <?php } ?>
            
    </body>
</html>
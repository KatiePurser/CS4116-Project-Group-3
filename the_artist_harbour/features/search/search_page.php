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
    </head>
    <body style="padding-top: 73.6px;">
        <div class="container-fluid">
            <div class="row g-0">
                <div class="col-12">
                    <?php include __DIR__ . '/../../templates/header.php'; ?>
                </div>
            </div>
        <?php 
            require_once("../../utilities/databaseHandler.php");
            require_once("../service/serviceDetails.php"); 
            require_once("searchMethods.php");
            
            $keyword=$_GET["search"];
            $tags = SearchMethods::readCSV("../../utilities/tags.csv")?>

            <div class="row">
                <div class="col-12">
                    <form action="search_page.php" method="get">
                        <input type="hidden" id="keyword" name="keyword" value=<?php echo $keyword?>
                        <input type="number" name="max_price" id="max_price">
                        <input type="number" name="min_price" id="min_price">
                        <select name="rating" id="rating">
                            <option value="1">1 Star</option>
                            <option value="2">2 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="5">5 Stars</option>
                        </select>
                        <select name="tags" id="tags">
                            <?php 
                            $i=0;
                            $tag = $tags[0];
                            while ($i < count($tags)) { ?>
                                <option value="<?php echo $tag ?>"><?php echo $tag ?></option>
                                <?php $i++;
                                $tag = next($tags);
                            }
                            ?>
                        </select>
                        <input type="submit" value="Add Filters">
                    </form>
                </div>
            </div>

            <?php
            //SEARCH SERVICES BY KEYWORD
            $sql = "SELECT * FROM services WHERE name LIKE '%{$keyword}%'";
            $result = DatabaseHandler::make_select_query($sql);
            $i=0; ?>
            <div class="justify-content-center">
                <h1 style="text-align: center;"> SERVICES </h1>
            </div> 
            <?php
            if(!isset($result)){
                ?> <h3 style="text-align: center;">NO SERVICES MATCH THE KEYWORD</h3> <?php
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
                                        <h4 class="card-subtitle"><?php echo ServiceDetails::getServicePrice($service["id"])."\n"; ?> </h4>
                                        <p class="card-text"><?php $rating = ServiceDetails::getServiceRating($service["id"]); 
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
                                        <h4 class="card-subtitle"><?php echo ServiceDetails::getServicePrice($service["id"])."\n"; ?></h4>
                                        <p class="card-text"><?php $rating = ServiceDetails::getServiceRating($service["id"]); 
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
                                        <h4 class="card-subtitle"><?php echo ServiceDetails::getServicePrice($service["id"])."\n"; ?></h4>
                                        <p class="card-text"><?php $rating = ServiceDetails::getServiceRating($service["id"]); 
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
                                        <h4 class="card-subtitle"><?php echo ServiceDetails::getServicePrice($service["id"])."\n"; ?></h4>
                                        <p class="card-text"><?php $rating = ServiceDetails::getServiceRating($service["id"]); 
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
                <div class="row">
                    <div class="card-group justify-content-center">
                        <?php while($i<count($result)){ ?>
                            <form action="../service/service.php" method="get">
                                <button type="submit">
                                    <input type="hidden" id="service_id" name="service_id" value=<?php echo $service["id"]?>>
                                    <div class="card hovercard text-center">
                                        <img class="card-img-top" src="https://placecats.com/300/200">
                                        <div class="card-body">
                                            <h3 class="card-title"><?php echo $service["name"]; ?></h3>
                                            <h4 class="card-subtitle"><?php echo ServiceDetails::getServicePrice($service["id"])."\n"; ?> </h4>
                                            <p class="card-text"><?php $rating = ServiceDetails::getServiceRating($service["id"]); 
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
            $sql = "SELECT * FROM businesses WHERE name LIKE '%{$keyword}%'";
            $result = DatabaseHandler::make_select_query($sql);
            $i=0; ?>
            <div>
                <h1 style="text-align: center;"> BUSINESSES </h1>
            </div>
            <?php
            if(!isset($result)){
                ?> <h3 style="text-align: center;">NO SERVICES MATCH THE KEYWORD</h3> <?php
            }else{ 
                $business=$result[0];
                while($i<count($result)-4){ ?>
                <div class="row justify-content-center">
                    <div class="card-group justify-content-center">
                        <form action="business.php" method="get">
                            <button type="submit">
                                <input type="hidden" id="business_id" name="business_id" value=<?php echo $business["id"]?>>
                                <div class="card hovercard text-center">
                                    <img class="card-img-top" src="https://placecats.com/300/200">
                                    <div class="card-body">
                                        <h3 class="card-title"><?php echo $business["name"]; ?></h3>
                                    </div>
                                </div>
                            </button>
                        </form>
                        <?php $business = next($result); 
                        $i++;?>
                        <form action="service.php" method="get">
                            <button type="submit">
                                <input type="hidden" id="business_id" name="business_id" value=<?php echo $business["id"]?>>
                                <div class="card hovercard text-center">
                                    <img class="card-img-top" src="https://placecats.com/300/200">
                                    <div class="card-body">
                                        <h3 class="card-title"><?php echo $business["name"]; ?></h3>
                                    </div>
                                </div>
                            </button>
                        </form>
                        <?php $business = next($result); 
                        $i++;?>
                        <form action="service.php" method="get">
                            <button type="submit">
                                <input type="hidden" id="business_id" name="business_id" value=<?php echo $business["id"]?>>
                                <div class="card hovercard text-center">
                                    <img class="card-img-top" src="https://placecats.com/300/200">
                                    <div class="card-body">
                                        <h3 class="card-title"><?php echo $business["name"]; ?></h3>
                                    </div>
                                </div>
                            </button>
                        </form>
                        <?php $business = next($result); 
                        $i++;?>
                        <form action="service.php" method="get">
                            <button type="submit">
                                <input type="hidden" id="business_id" name="business_id" value=<?php echo $business["id"]?>>
                                <div class="card hovercard text-center">
                                    <img class="card-img-top" src="https://placecats.com/300/200">
                                    <div class="card-body">
                                        <h3 class="card-title"><?php echo $business["name"]; ?></h3>
                                    </div>
                                </div>
                            </button>
                        </form>
                        <?php $business = next($result); 
                        $i++;?>
                    </div>
                </div>
                <?php } ?>
                <div class="row">
                    <div class="card-group justify-content-center">
                        <?php while($i<count($result)){ ?>
                            <form action="service.php" method="get">
                                <button type="submit">
                                    <input type="hidden" id="business_id" name="business_id" value=<?php echo $business["id"]?>>
                                    <div class="card hovercard text-center">
                                        <img class="card-img-top" src="https://placecats.com/300/200">
                                        <div class="card-body">
                                            <h3 class="card-title"><?php echo $business["name"]; ?></h3>
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
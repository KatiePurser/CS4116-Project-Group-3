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
        <style>
            div {
                padding: 0 !important;
            }

            @media(max-width: 576px) {     /*small screen*/
                .row {
                    width: 100%;
                    display: flex;
                    align-content: center;
                }

                .business-button{
                    text-decoration: none;
                    background-color: #E2D4F0;
                    color: black;
                    padding: 0.25vw;
                    text-align: center;
                    text-decoration: none;
                    display: inline-block;
                    border-radius: 0.25vw;
                }
                .card-group{
                    align-content: center;
                }
                
                .card_button {
                    width: 90vw;
                    padding-left: 1vw;
                    padding-right: 1vw;
                    border: none;
                    background-color: Transparent;
                    align-content: center;
                }

                .hovercard {
                    width:100%;
                    height:100%;
                    word-wrap: break-word;
                    border-color: #82689A;
                    border-radius: 1vw;
                    border-width: 0.2vw;
                    margin-bottom: 1vh;
                }

                .card-title {
                    display: block;
                    word-wrap: break-word;
                    max-width:100%;
                }

                .service_price {
                    background-color: #82689A;
                    color: white;
                    border-radius: 0.5vw;
                    max-width: fit-content;
                    margin: auto;
                    padding-left: 0.5vw;
                    padding-right: 0.5vw;
                }

                .image{
                    height: 30vh;
                    object-fit: cover;
                    
                }
            }

            @media(min-width: 576px) {  	/*wide screen*/
                .row {
                    width: 100%;
                    display: flex;
                    align-content: center;
                }

                .business-button{
                    text-decoration: none;
                    background-color: #E2D4F0;
                    color: black;
                    padding: 0.25vw;
                    text-align: center;
                    text-decoration: none;
                    display: inline-block;
                    border-radius: 0.25vw;
                }

                .card-group{
                    align-content: center;
                    margin-bottom: 1vh;
                }

                .card_button {
                    width: 24vw;
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
                    color: white;
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

                .image{
                    height: 30vh;
                    object-fit: cover;
                    border-radius: 1vw;
                }
            }
        </style>
    </head>
    <body style="padding-top: 73.6px;">
        <div class="container-fluid">
            <div class="row g-0">
                <div class="col-12">
                    <?php include __DIR__ . '/../templates/header.php'; 
                    if (!empty($_SESSION['error'])) {
                        echo("<div class='row mb-2 g-0'><div class='alert alert-danger'><span><i class='bi bi-exclamation-triangle'></span></i> {$_SESSION['error']} </div><div class='col-12'></div></div>");
                        unset($_SESSION['error']);
                    }?>
                </div>
            </div>

            <div class="row g-0">
                <div class="col-12 text-center">
                    <h1>WELCOME TO THE ARTIST HARBOUR</h1>
                    <h3>We are a collective working to make a safe and community-based space for artists to market their bespoke services</h3>
                </div>
            </div>
            <br><br>
            <div class="row g-0">
                <div class="col-12 text-center">
                    <h2 class="background">OUR TOP-RATED SERVICES</h2>
                </div>
            </div>
            <br>
        </div>

        <?php
            require_once(__DIR__ . "/../utilities/databaseHandler.php");
            require_once(__DIR__ . "/../features/service/serviceDetails.php");
            require_once(__DIR__ . "/../utilities/imageHandler.php");
            require_once(__DIR__ . "/../features/search/searchMethods.php");
            //connect to DB
            // $sql = "SELECT * FROM services ORDER BY reviews";
            $sql = "SELECT * FROM services ORDER BY reviews DESC";    //will need to figure out how to order by rating, which is stored in reviews table
            $result = DatabaseHandler::make_select_query($sql);
            $businesses = DatabaseHandler::make_select_query("SELECT id, display_name FROM businesses ");
            $i=0;
            $service = $result[0];
            while($i<12 && $i<=(count($result)-4)) {
                ?>
                <div class="card-group justify-content-center row g-0">
                    <div class="col-sm-3">
                        <form class="card_form" action="../features/service/service.php" method="get">
                            <button class="card_button" type="submit">
                                <input type="hidden" id="service_id" name="service_id" value=<?php echo $service["id"]?>>
                                <div class="card hovercard text-center">
                                    <?php if (!empty($service['image'])){ ?>
                                        <img src="../features/business/get_serviceImage.php?id=<?= $service['id'] ?>" class="card-img-top image" alt="Service Image">
                                    <?php }else{ ?>
                                        <img src="images/default-service.png" class="card-img-top image" alt="Default Image">
                                    <?php } ?>
                                    <div class="card-body">
                                        <h3 class="card-title"><?php echo $service["name"]; ?></h3>
                                        <?php $url = "../features/business/profile.php?business_id=".$service['business_id'];
                                        echo '<a class="business-button" href='.$url.'>'. searchMethods::getBusinessName($businesses, $service['business_id']).'</a>'; ?>
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
                        <form class="card_form" action="../features/service/service.php" method="get">
                            <button class="card_button" type="submit">
                                <input type="hidden" id="service_id" name="service_id" value=<?php echo $service["id"]?>>
                                <div class="card hovercard text-center">
                                    <?php if (!empty($service['image'])){ ?>
                                        <img src="../features/business/get_serviceImage.php?id=<?= $service['id'] ?>" class="card-img-top image" alt="Service Image">
                                    <?php }else{ ?>
                                        <img src="images/default-service.png" class="card-img-top image" alt="Default Image">
                                    <?php } ?>
                                    <div class="card-body">
                                        <h3 class="card-title"><?php echo $service["name"]; ?></h3>
                                        <?php $url = "../features/business/profile.php?business_id=".$service['business_id'];
                                        echo '<a class="business-button" href='.$url.'>'. searchMethods::getBusinessName($businesses, $service['business_id']).'</a>'; ?>
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
                        <form class="card_form" action="../features/service/service.php" method="get">
                            <button class="card_button" type="submit">
                                <input type="hidden" id="service_id" name="service_id" value=<?php echo $service["id"]?>>
                                <div class="card hovercard text-center">
                                    <?php if (!empty($service['image'])){ ?>
                                        <img src="../features/business/get_serviceImage.php?id=<?= $service['id'] ?>" class="card-img-top image" alt="Service Image">
                                    <?php }else{ ?>
                                        <img src="images/default-service.png" class="card-img-top image" alt="Default Image">
                                    <?php } ?>
                                    <div class="card-body">
                                        <h3 class="card-title"><?php echo $service["name"]; ?></h3>
                                        <?php $url = "../features/business/profile.php?business_id=".$service['business_id'];
                                        echo '<a class="business-button" href='.$url.'>'. searchMethods::getBusinessName($businesses, $service['business_id']).'</a>'; ?>
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
                        <form class="card_form" action="../features/service/service.php" method="get">
                            <button class="card_button" type="submit">
                                <input type="hidden" id="service_id" name="service_id" value=<?php echo $service["id"]?>>
                                <div class="card hovercard text-center">
                                    <?php if (!empty($service['image'])){ ?>
                                        <img src="../features/business/get_serviceImage.php?id=<?= $service['id'] ?>" class="card-img-top image" alt="Service Image">
                                    <?php }else{ ?>
                                        <img src="images/default-service.png" class="card-img-top image" alt="Default Image">
                                    <?php } ?>
                                    <div class="card-body">
                                        <h3 class="card-title"><?php echo $service["name"]; ?></h3>
                                        <?php $url = "../features/business/profile.php?business_id=".$service['business_id'];
                                        echo '<a class="business-button" href='.$url.'>'. searchMethods::getBusinessName($businesses, $service['business_id']).'</a>'; ?>
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
            <?php } ?>
            <div class="card-group justify-content-center">
                    <?php while($i<count($result) && $i<12){ ?>
                        <form class="card_form" action="../features/service/service.php" method="get">
                            <button class="card_button" type="submit">
                                <input type="hidden" id="service_id" name="service_id" value=<?php echo $service["id"]?>>
                                <div class="card hovercard text-center">
                                    <?php if (!empty($service['image'])){ ?>
                                        <img src="../features/business/get_serviceImage.php?id=<?= $service['id'] ?>" class="card-img-top image" alt="Service Image">
                                    <?php }else{ ?>
                                        <img src="images/default-service.png" class="card-img-top image" alt="Default Image">
                                    <?php } ?>
                                    <div class="card-body">
                                        <h3 class="card-title"><?php echo $service["name"]; ?></h3>
                                        <?php $url = "../features/business/profile.php?business_id=".$service['business_id'];
                                        echo '<a class="business-button" href='.$url.'>'. searchMethods::getBusinessName($businesses, $service['business_id']).'</a>'; ?>
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
                        <?php $service = next($result);  
                        $i++;?>
                    <?php } ?>
                </div>
            </div>

            <div class="row">
                <?php //include __DIR__ . '/../templates/footer.php'; ?>
            </div>        
    </body>
</html>
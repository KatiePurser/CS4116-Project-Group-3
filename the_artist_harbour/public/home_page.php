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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            div {
                padding: 0 !important;
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
        </div>

        <?php
            require_once(__DIR__ . "/../utilities/databaseHandler.php");
            require_once(__DIR__ . "/../features/service/serviceDetails.php");
            //connect to DB
            // $sql = "SELECT * FROM services ORDER BY reviews";
            $sql = "SELECT * FROM services ORDER BY reviews DESC";    //will need to figure out how to order by rating, which is stored in reviews table
            $result = DatabaseHandler::make_select_query($sql);
            // $sql = "SELECT COUNT(*) FROM services";
            // $count = DatabaseHandler::make_select_query($sql);
            $i=0;
            $service = $result[0];
            while($i<12 && $i<=(count($result)-4)) {
                ?>
            <div class="row justify-content-center">
                <div class="card-group justify-content-center">
                    <form action="../features/service/service.php" method="get">
                        <button class=card_button type="submit">
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
                    <form action="../features/service/service.php" method="get">
                        <button class=card_button type="submit">
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
                    <form action="../features/service/service.php" method="get">
                        <button class=card_button type="submit">
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
                    <form action="../features/service/service.php" method="get">
                        <button class=card_button type="submit">
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
            <div class="row">
                <div class="card-group justify-content-center">
                    <?php while($i<count($result) && $i<12){ ?>
                        <form action="../features/service/service.php" method="get">
                            <button class=card_button type="submit">
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

            <div class="row">
                <?php //include __DIR__ . '/../templates/footer.php'; ?>
            </div>        
    </body>
</html>
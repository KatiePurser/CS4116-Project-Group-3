<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>The Artist Harbour</title>
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
        <div class="container-fluid">
            <div class="row g-0">
                <div class="col-12">
                    <?php include __DIR__ . '/../templates/header.php'; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-12 text-center">
                    <h1>WELCOME TO THE ARTIST HARBOUR</h1>
                    <h3>We are a collective working to make a safe and community-based space for artists to market their bespoke services</h3>
                </div>
            </div>
        </div>

        <?php
            include_once("../utilities/DatabaseHandler.php");
            include_once("../utilities/ServiceDetails.php");
            //connect to DB
            $sql = "SELECT  FROM services ORDER BY rating";
            $result = DatabaseHandler::make_select_query($sql);
            $sql = "SELECT COUNT(*) FROM services";
            $count = DatabaseHandler::make_select_query($sql);
            $i=0;
            while($i<12 && $i<=$count-4){
                ?>
            <div class="row justify-content-center">
                <div class="card-group">
                    <form action="about_us.html">
                        <?php $service = mysqli_fetch_assoc($result); //may need to swap the DB functions for just mysqli functions
                        $i++;?>
                        <button type="submit">
                            <input type="hidden" id="service_id" name="service_id" value=<?php echo $service["id"]?>>
                            <div class="card hovercard text-center">
                                <img class="card-img-top" src="https://placecats.com/300/200">
                                <div class="card-body">
                                    <h3 class="card-title"><?php echo $service["name"]; ?></h3>
                                    <h4 class="card-subtitle"><?php echo ServiceDetails::getServicePrice($service["id"]); ?> </h4>
                                    <p class="card-text"><?php echo ServiceDetails::getServiceRating($service["id"]); ?></p>
                                </div>
                            </div>
                        </button>
                    </form>
                    <form action="about_us.html">
                        <?php $service = mysqli_fetch_assoc($result); 
                        $i++;?>
                        <button type="submit">
                            <input type="hidden" id="service_id" name="service_id" value=<?php echo $service["id"]?>>
                            <div class="card hovercard text-center">
                                <img class="card-img-top" src="https://placecats.com/300/200">
                                <div class="card-body">
                                    <h3 class="card-title"><?php echo $service["name"]; ?></h3>
                                    <h4 class="card-subtitle"><?php echo ServiceDetails::getServicePrice($service["id"]); ?></h4>
                                    <p class="card-text"><?php echo ServiceDetails::getServiceRating($service["id"]); ?></p>
                                </div>
                            </div>
                        </button>
                    </form>
                    <form action="about_us.html">
                        <?php $service = mysqli_fetch_assoc($result); 
                        $i++;?>
                        <button type="submit">
                            <input type="hidden" id="service_id" name="service_id" value=<?php echo $service["id"]?>>
                            <div class="card hovercard text-center">
                                <img class="card-img-top" src="https://placecats.com/300/200">
                                <div class="card-body">
                                    <h3 class="card-title"><?php echo $service["name"]; ?></h3>
                                    <h4 class="card-subtitle"><?php echo ServiceDetails::getServicePrice($service["id"]); ?></h4>
                                    <p class="card-text"><?php echo ServiceDetails::getServiceRating($service["id"]); ?></p>
                                </div>
                            </div>
                        </button>
                    </form>
                    <form action="about_us.html">
                        <?php $service = mysqli_fetch_assoc($result); 
                        $i++;?>
                        <input type="hidden" id="service_id" name="service_id" value=<?php echo $service["id"]?>>
                        <button type="submit">
                            <div class="card hovercard text-center">
                                <img class="card-img-top" src="https://placecats.com/300/200">
                                <div class="card-body">
                                    <h3 class="card-title"><?php echo $service["name"]; ?></h3>
                                    <h4 class="card-subtitle"><?php echo ServiceDetails::getServicePrice($service["id"]); ?></h4>
                                    <p class="card-text"><?php echo ServiceDetails::getServiceRating($service["id"]); ?></p>
                                </div>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
            <?php } ?>
            <div class="row">
                <div class="card-group">
                    <?php while($i<$count){ ?>
                        <form action="about_us.html">
                            <?php $service = mysqli_fetch_assoc($result); 
                            $i++;?>
                            <button type="submit">
                                <input type="hidden" id="service_id" name="service_id" value=<?php echo $service["id"]?>>
                                <div class="card hovercard text-center">
                                    <img class="card-img-top" src="https://placecats.com/300/200">
                                    <div class="card-body">
                                        <h3 class="card-title"><?php echo $service["name"]; ?></h3>
                                        <h4 class="card-subtitle"><?php echo ServiceDetails::getServicePrice($service["id"]); ?> </h4>
                                        <p class="card-text"><?php echo ServiceDetails::getServiceRating($service["id"]); ?></p>
                                    </div>
                                </div>
                            </button>
                        </form>
                    <?php } ?>
                </div>
            </div>

            <div class="row">
                <?php include __DIR__ . '/../templates/footer.php'; ?>
            </div>        
    </body>
</html>
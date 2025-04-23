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
            
            .review-title {
                text-align:center;
                color: white;
                background-color: #82689A;
                border-radius: 5px;
                max-width: fit-content;
                margin-bottom: 1%;
                padding: 0.25vw
            }

            .hovercard {
                margin-bottom: 1%;
                margin-left: 1%;
                margin-right: 1%;
                border-color: #82689A;
                border-radius: 5%;
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
                        <?php }else{ ?>
                            <h3 class="price"> <?php echo "€".$service['min_price']." - €".$service['max_price']; ?></h3>
                        <?php }
                        ?>
                    </div>
                    <div class="service_request">
                        <?php if($_SESSION['user_type'] == 'customer') { 
                            if($service['min_price']==NULL){?>
                                <button type="button" class="btn service-request-btn p-0" data-bs-toggle="modal" data-bs-target="#serviceRequestModal"
                                    data-price-final="<?php echo $service['max_price']?>" data-service-id="<?php echo $service_id?>">
                                    Request Service
                                </button>
                            <?php } else { ?>
                                <button type="button" class="btn p-0" data-bs-toggle="modal" data-bs-target="#serviceRequestModal"
                                    data-price-final="0" data-service-id="<?php echo $service_id?>">
                                    Request Service
                                </button>
                            <?php } ?>
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
        <div class="row g-0 justify-content-center">
            <div class="review-title">
                <h2> REVIEWS </h2>
            </div>
        </div>
        <div class="reviews_containter">
        <?php
        //RETRIEVE REVIEWS FROM REVIEWS TABLE
        $sql = "SELECT * FROM reviews WHERE service_id={$service_id}";
        $result = DatabaseHandler::make_select_query($sql);
        if($result == NULL){ ?>
            <h3 style="text-align: center;"> NO REVIEWS </h3>
        <?php } else{
            $review = $result[0];
            $i=0;
            while($i<count($result)-3){?>
            <div class=" row g-0 card-group justify-content-center">
                <div class="card hovercard text-center">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo ServiceDetails::getReviewer($review['reviewer_id'])?></h3>
                        <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#reviewReportModal"
                            data-review-id="<?php echo $review['id'] ?>" data-reported-id="<?php echo $review['reviewer_id'] ?>" 
                            data-review-content="<?php echo $review['text']?>" data-service-id="<?php echo $review['service_id']?>" style="float: right;">
                            <i class="bi bi-flag" title="Report this message" style="color:red;"></i>
                        </button>
                        <p class="card-text"><?php echo $review['text'] ?></p>
                        <?php if ($_SESSION['user_type'] == 'customer'){?>
                        <button type="button" class="btn p-0" data-bs-toggle="modal" data-bs-target="#insightRequestModal"
                            data-receiver-id="<?php echo $review['reviewer_id']?>" data-service-id="<?php echo $service_id?>" style="background-color: #82689A; border-width: 2%; border-color: #82689A; color: white;">
                            Request Insight
                        </button>
                        <?php } ?>
                    </div>
                </div>
                <?php $i++; 
                $review=next($result);?>
                <div class="card hovercard text-center">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo ServiceDetails::getReviewer($review['reviewer_id'])?></h3>
                        <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#reviewReportModal"
                            data-review-id="<?php echo $review['id']; ?>" data-reported-id="<?php echo $review['reviewer_id']; ?>" 
                            data-review-content="<?php echo $review['text']?>" data-service-id="<?php echo $review['service_id']?>" style="float: right;">
                            <i class="bi bi-flag" title="Report this message" style="color:red;"></i>
                        </button>
                        <p class="card-text"><?php echo $review['text'] ?></p>
                        <?php if ($_SESSION['user_type'] == 'customer'){?>
                        <button type="button" class="btn p-0" data-bs-toggle="modal" data-bs-target="#insightRequestModal"
                            data-receiver-id="<?php echo $review['reviewer_id']?>" data-service-id="<?php echo $service_id?>" style="background-color: #82689A; border-width: 2%; border-color: #82689A; color: white;">
                            Request Insight
                        </button>
                        <?php } ?>
                    </div>
                </div>
                <?php $i++; 
                $review=next($result);
                ?>
                <div class="card hovercard text-center">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo ServiceDetails::getReviewer($review['reviewer_id'])?></h3>
                        <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#reviewReportModal"
                            data-review-id="<?php echo $review['id']; ?>" data-reported-id="<?php echo $review['reviewer_id']; ?>" 
                            data-review-content="<?php echo $review['text']?>" data-service-id="<?php echo $review['service_id']?>" style="float: right;">
                            <i class="bi bi-flag" title="Report this message" style="color:red;"></i>
                        </button>
                        <p class="card-text"><?php echo $review['text'] ?></p>
                        <?php if ($_SESSION['user_type'] == 'customer'){?>
                        <button type="button" class="btn p-0" data-bs-toggle="modal" data-bs-target="#insightRequestModal"
                            data-receiver-id="<?php echo $review['reviewer_id']?>" data-service-id="<?php echo $service_id?>" style="background-color: #82689A; border-width: 2%; border-color: #82689A; color: white;">
                            Request Insight
                        </button>
                        <?php } ?>
                    </div>
                </div>
                <?php $i++; 
                $review=next($result);?>
            </div>
            <?php } ?>
            <div class=" row g-0 card-group justify-content-center">
                <?php while($i<count($result)){ ?>
                <div class="card hovercard text-center">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo ServiceDetails::getReviewer($review['reviewer_id'])?></h3>
                        <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#reviewReportModal"
                            data-review-id="<?php echo $review['id']; ?>" data-reported-id="<?php echo $review['reviewer_id']; ?>" 
                            data-review-content="<?php echo $review['text']?>" data-service-id="<?php echo $review['service_id']?>" style="float: right;">
                            <i class="bi bi-flag" title="Report this message" style="color:red;"></i>
                        </button>
                        <p class="card-text"><?php echo $review['text'] ?></p>
                        <?php if ($_SESSION['user_type'] == 'customer'){?>
                        <button type="button" class="btn p-0" data-bs-toggle="modal" data-bs-target="#insightRequestModal"
                            data-receiver-id="<?php echo $review['reviewer_id']?>" data-service-id="<?php echo $service_id?>" style="background-color: #82689A; border-width: 2%; border-color: #82689A; color: white;">
                            Request Insight
                        </button>
                        <?php } ?>
                    </div>
                </div>
                <?php $i++; 
                $review=next($result);}?>
            </div>
            <?php } ?>
        </div>

    </body>
</html>
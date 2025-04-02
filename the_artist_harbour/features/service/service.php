<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /CS4116-Project-Group-3/the_artist_harbour/features/registration-login/login.php");
    exit();
}

// if ($_SESSION['user_type'] != 'customer' || $_SESSION['user_type'] != 'business') {
//     exit();
// }


require_once(__DIR__ . "/../../utilities/databaseHandler.php");
require_once(__DIR__ . "/serviceDetails.php"); 
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
        <link rel="stylesheet" href="public/css/styles.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body style="padding-top: 73.6px;">
        <div class="row g-0">
            <div class="col-12">
                <?php include __DIR__ . '/../../templates/header.php'; ?>
            </div>
        </div>

        <div class="row g-0">
            <div class="col-6">
                <div class="name">
                    <?php echo $service['name'] ?>
                </div>
                <div class="business_name">
                    <?php echo $business['display_name'] ?>
                </div>
                <div class="description">
                    <?php echo $service['description'] ?>
                </div>
                <div class="tags">
                    <?php 
                    if($service['tags']!=NULL){
                        $tags=explode(",", $services['tags'], 25);
                        $i=0;
                        echo "Tags: ";
                        while($i<count($tags)){
                            echo $tags[$i];
                            if($i!=count($tags)-1){
                                echo ", ";
                            }
                        }
                    } ?>
                </div>
                <div>
                    <div class="price" style="float:left;">
                        <?php 
                        if($service['min_price']==NULL){
                            echo "€".$service['max_price'];
                        }else{
                            echo "€".$service['min_price']." - €".$service['max_price'];
                        }
                        ?>
                    </div>
                    <div class="service_request" style="float:right ;">
                        <button>Request Service</button>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <?php
                if($service['image']!=NULL){
                    //image is set
                }else{?>
                    <img src="https://placecats.com/300/200">
                <?php }
                ?>
            </div>
        </div>
        <br><br><br>
        <div class="review_title" style="text-align:center;">
            <h2> REVIEWS </h2>
        </div>
        <div class="reviews_containter">
        <?php
        //RETRIEVE REVIEWS FROM REVIEWS TABLE
        $sql = "SELECT * FROM reviews WHERE service_id=$service_id";
        $result = DatabaseHandler::make_select_query($sql);
        if($result == NULL){ ?>
            <h3 style="text-align: center;"> NO REVIEWS </h3>
        <?php } else{
            $review = $result[0];
            $i=0;
            while($i<count($result)-3){ $i++;?>
            <div class=" row g-0 card-group justify-content-center">
                <div class="card hovercard text-center">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo ServiceDetails::getReviewer($review['reviewer_id'])?></h3>
                        <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#reportModal"
                            data-message-id="<?php echo $message['id']; ?>" data-reported-id="<?php echo $message['sender_id']; ?>" style="float: right;">
                            <i class="bi bi-flag" title="Report this message" style="color:red;"></i>
                        </button>
                        <p class="card-text"><?php echo $review['text'] ?></p>
                    </div>
                </div>
                <?php $i++; $review=next($result)?>
                <div class="card hovercard text-center">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo ServiceDetails::getReviewer($review['reviewer_id'])?></h3>
                        <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#reportModal"
                            data-message-id="<?php echo $message['id']; ?>" data-reported-id="<?php echo $message['sender_id']; ?>" style="float: right;">
                            <i class="bi bi-flag" title="Report this message" style="color:red;"></i>
                        </button>
                        <p class="card-text"><?php echo $review['text'] ?></p>
                    </div>
                </div>
                <?php $i++; $review=next($result)?>
                <div class="card hovercard text-center">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo ServiceDetails::getReviewer($review['reviewer_id'])?></h3>
                        <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#reportModal"
                            data-message-id="<?php echo $message['id']; ?>" data-reported-id="<?php echo $message['sender_id']; ?>" style="float: right;">
                            <i class="bi bi-flag" title="Report this message" style="color:red;"></i>
                        </button>
                        <p class="card-text"><?php echo $review['text'] ?></p>
                    </div>
                </div>
                <?php $i++; $review=next($result)?>
            </div>
            <?php } ?>
            <div class=" row g-0 card-group justify-content-center">
                <?php while($i<count($result)){ ?>
                <div class="card hovercard text-center">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo ServiceDetails::getReviewer($review['reviewer_id'])?></h3>
                        <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#reportModal"
                            data-message-id="<?php echo $message['id']; ?>" data-reported-id="<?php echo $message['sender_id']; ?>" style="float: right;">
                            <i class="bi bi-flag" title="Report this message" style="color:red;"></i>
                        </button>
                        <p class="card-text"><?php echo $review['text'] ?></p>
                    </div>
                </div>
                <?php $i++; $review=next($result); }?>
            </div>
            <?php } ?>
        </div>
    </body>
</html>
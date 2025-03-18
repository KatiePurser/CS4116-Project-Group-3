<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>The Artist Harbour</title>

        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css bootstrap.min.css"
            integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
            crossorigin="anonymous">
        <link rel=" stylesheet" href="assets/css/styles.css">
        
    </head>
    <body>
        <?php include __DIR__ . '/../includes/header.php'; ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center">
                    <h1>WELCOME TO THE ARTIST HARBOUR</h1>
                    <h3>We are a collective working to make a safe and community-based space for artists to market their bespoke services</h3>
                </div>
            </div>
        </div>

        <?php
            include_once("DatabaseHandler.php");
            //connect to DB
            $sql = "SELECT * FROM services ORDER BY rating";
            $result = make_select_query($sql);
            $sql = "SELECT COUNT(*) FROM services";
            $count = make_select_query($sql);
            if($count>=12){
                $i=0;
                while($i<3){
                    $service = mysqli_fetch_assoc($result);
                    ?>
                    <div class="row">
                        <div class="col-4">
                            <div class="card hovercard text-center">
                                <img class="card-img-top" src="<?php echo $service['image']; ?>">
                                <div class="card-body">
                                    <h3 class="card-title"><?php echo $service['name']; ?></h3>
                                    <h4 class="card-subtitle"><?php echo $service['price']; ?></h4>
                                    <p class="card-text"><?php echo $service['rating']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                        </div>
                        <?php $service = mysqli_fetch_assoc($result); ?>
                        <div class="col-4">
                            <div class="card hovercard text-center">
                                <img class="card-img-top" src="<?php echo $service['image']; ?>">
                                <div class="card-body">
                                    <h3 class="card-title"><?php echo $service['name']; ?></h3>
                                    <h4 class="card-subtitle"><?php echo $service['price']; ?></h4>
                                    <p class="card-text"><?php echo $service['rating']; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php $service = mysqli_fetch_assoc($result); ?>
                        <div class="col-4">
                            <div class="card hovercard text-center">
                                <img class="card-img-top" src="<?php echo $service['image']; ?>">
                                <div class="card-body">
                                    <h3 class="card-title"><?php echo $service['name']; ?></h3>
                                    <h4 class="card-subtitle"><?php echo $service['price']; ?></h4>
                                    <p class="card-text"><?php echo $service['rating']; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php $service = mysqli_fetch_assoc($result); ?>
                        <div class="col-4">
                            <div class="card hovercard text-center">
                                <img class="card-img-top" src="<?php echo $service['image']; ?>">
                                <div class="card-body">
                                    <h3 class="card-title"><?php echo $service['name']; ?></h3>
                                    <h4 class="card-subtitle"><?php echo $service['price']; ?></h4>
                                    <p class="card-text"><?php echo $service['rating']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $i++; ?>
        <?php }} ?>

        //PHP script to retrieve top rated services from database -
        //SELECT * FROM services ORDER BY rating 
        //if there are at least 12 entries in the table, iterate through the top 12 and lay them out
        //if there are less than 12, just display however many there are 
        
    </body>
</html>
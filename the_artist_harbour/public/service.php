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
        <?php $service_id=$_GET["service_id"];
        $sql = "SELECT * FROM services WHERE id=$service_id";
        $result = DatabaseHandler::make_select_query($sql);
        $service = $result[0];
        
        
        //RETRIEVE REVIEWS FROM REVIEWS TABLE
        $sql = "SELECT * FROM reviews WHERE service_id=$service_id";
        $result = DatabaseHandler::make_select_query($sql);
        $review = $result[0];
        $i=0;
        while($i<count($result)){ ?>
            <div
            
        <?php } ?>

        echo "ON DA SERVICE PAGE";
        ?>
    </body>
</html>
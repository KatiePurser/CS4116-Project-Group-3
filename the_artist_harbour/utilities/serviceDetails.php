<?php

/**
 * Class GetServiceDetails
 *
 * This class provides methods for retrieving the correct data about a service from the database.
 */

class ServiceDetails{

    public static function getServicePrice($serviceId){
        include_once("../utilities/DatabaseHandler.php");
        $sql = "SELECT min_price, max_price FROM services WHERE service_id={$serviceId}";
        $result = DatabaseHandler::make_select_query($sql);
        $prices = mysqli_fetch_assoc($result);
        if($service["min_price"]!=NULL){
            return "€{$max_price}";
        }else{
            return "€{$min_price} - €{$max_price}";
        }
    }

    public static function getServiceRating($serviceId){
        include_once("../utilities/DatabaseHandler.php");
        $sql = "SELECT AVG(rating) FROM reviews WHERE service_id={$serviceId}";
        $rating = DatabaseHandler::make_select_query($sql);
        return $rating;
    }
}
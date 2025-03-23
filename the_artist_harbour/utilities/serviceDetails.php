<?php

/**
 * Class GetServiceDetails
 *
 * This class provides methods for retrieving the correct data about a service from the database.
 */

class ServiceDetails{
    public static function getServicePrice($serviceId){
        require_once __DIR__ . '/databaseHandler.php';

        $sql = "SELECT min_price, max_price FROM services WHERE id = $serviceId";
        $prices = DatabaseHandler::make_select_query($sql);
        $service_price = $prices[0];

        if($service_price["min_price"]===null){
            return "€".$service_price["max_price"];
        }else{
            return "€".$service_price["min_price"]." - €".$service_price["max_price"];
        }
    }

    public static function getServiceRating($serviceId){

        $sql = "SELECT AVG(rating) FROM reviews WHERE service_id = $serviceId";
        $result = DatabaseHandler::make_select_query($sql);

        if(!isset($result[0])){
            return "Not yet reviewed";
        }else{
            $rating = $result[0];
            return "{$rating["rating"]}/5";
        }
    }
}
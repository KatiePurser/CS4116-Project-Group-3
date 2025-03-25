<?php

/**
 * Class GetServiceDetails
 *
 * This class provides methods for retrieving the correct data about a service from the database.
 */

class ServiceDetails{
    public static function getServicePrice($serviceId){
        require_once(__DIR__.'/../../utilities/databaseHandler.php');

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
        require_once(__DIR__.'/../../utilities/databaseHandler.php');

        $sql = "SELECT rating FROM reviews WHERE service_id = $serviceId";
        $result = DatabaseHandler::make_select_query($sql);

        if(!isset($result[0])){
            return "Not yet reviewed";
        }else{
            $row = $result[0];
            $i=0;
            $total=0;
            while($i<count($result)){
                $total+=$row["rating"];
                $i++;
                $row=next($result);
            }
            $final = $total/$i;
            return "{$final}/5";
        }
    }
}
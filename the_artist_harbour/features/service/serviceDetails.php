<?php

/**
 * Class GetServiceDetails
 *
 * This class provides methods for retrieving the correct data about a service from the database.
 */

class ServiceDetails{
    public static function getServicePrice($min_price, $max_price){
        if($min_price===null){
            return "€".$max_price;
        }else{
            return "€".$min_price." - €".$max_price;
        }
    }

    public static function getRating($rating){
        if($rating===null){
            return "Not yet reviewed";
        }else{
            return "{$rating}/5";
        }
    }
}
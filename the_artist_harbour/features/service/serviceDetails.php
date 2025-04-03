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

    public static function getReviewer($id){
        require_once(__DIR__ . "/../../utilities/databaseHandler.php");

        $sql="SELECT first_name, last_name FROM users WHERE id={$id}";
        $reviewer = DatabaseHandler::make_select_query($sql);
        return $reviewer[0]['first_name']." ".$reviewer[0]['last_name'];
    }
}
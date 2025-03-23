<?php

/**
 * Class GetServiceDetails
 *
 * This class provides methods for retrieving the correct data about a service from the database.
 */

class ServiceDetails{

    private static $servername = "the-artist-harbour.cl64o2auodev.eu-north-1.rds.amazonaws.com";
    private static $username = "admin";
    private static $password = "password2025";
    private static $dbname = "artist_harbour_db";

    public static function getServicePrice($serviceId){
        include_once("../utilities/DatabaseHandler.php");

        //what ended up working

        // $conn = new mysqli(static::$servername, static::$username, static::$password, static::$dbname);
        
        // if ($conn->connect_error) {
        //     error_log("Connection failed: " . $conn->connect_error);
        //     return null;
        // }

        // $stmt = $conn->prepare("SELECT * FROM services WHERE id=?");
        // $stmt->bind_param("s", $serviceId);
        // $stmt->execute();
        // $result = $stmt->get_result();
        // $prices = $result->fetch_assoc();

        //what I tried (not working)

        $sql = "SELECT min_price, max_price FROM services WHERE id = $serviceId";
        $prices = DatabaseHandler::make_select_query($sql);


        if(!isset($prices["min_price"]) && !isset($prices["max_price"])){
            echo"UH OH";
        }else if(!isset($prices["min_price"])){
            return "€{$prices["max_price"]}";
        }else{
            return "€{$prices["min_price"]} - €{$prices["max_price"]}";
        }
    }

    public static function getServiceRating($serviceId){
        $conn = new mysqli(static::$servername, static::$username, static::$password, static::$dbname);
        
        if ($conn->connect_error) {
            error_log("Connection failed: " . $conn->connect_error);
            return null;
        }

        $stmt = $conn->prepare("SELECT rating FROM reviews WHERE service_id=?");
        $stmt->bind_param("s", $serviceId);
        $stmt->execute();
        $result = $stmt->get_result();
        $rating = $result->fetch_assoc();

        if(!isset($rating["rating"])){
            return "Not yet reviewed";
        }else{
            return "{$rating["rating"]}/5";
        }
    }
}
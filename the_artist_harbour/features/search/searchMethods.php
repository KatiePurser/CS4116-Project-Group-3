<?php

    class searchMethods{
        
        public static function getBusinessName($businesses, $business_id){
            $i=0;
            $cond=false;
            while($cond==false && $i<count($businesses)){
                if($businesses[$i]['id']==$business_id){
                    $business_name = $businesses[$i]['display_name'];
                    $cond=true;
                }
                $i++;
            }
            return $business_name;
        }
        
        public static function getProfileImage($users, $user_id){
            $i=0;
            while($i<count($users)){
                if($users[$i]['id']==$user_id){
                    if(isset($users[$i]['profile_picture'])){
                        return true;
                    }else{
                        return false;
                    }
                }
                $i++;
            }

        }

        public static function read($csv){
            $file = fopen($csv, 'r');
            while (!feof($file) ) {
                $line[] = fgetcsv($file, 1024);
            }
            fclose($file);
            return $line;
        }
    }

?>
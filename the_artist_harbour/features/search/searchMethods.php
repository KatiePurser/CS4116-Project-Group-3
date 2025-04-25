<?php

    class searchMethods{
        public static function readCSV($csvFile){
            $file_handle = fopen($csvFile, 'r');
            while (!feof($file_handle) ) {
                $line_of_text[] = fgetcsv($file_handle, 1024);
            }
            fclose($file_handle);
            return $line_of_text;
        }

        public static function formatTags($tags){
            $tags_array = explode("," , $tags);
            $i=0;
            $tags_return = "";
            while($i<count($tags_array)){
                $tags_return.=$tags_array[$i];
                if($i<count($tags_array)-1){
                    $tags_return.=", ";
                }
                $i++;
            }
            return $tags_return;
        }

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
<?php
class ImageHandler {

    /**
     * Uploads an image, converts it to a BLOB, and stores it in the database.
     */
    public static function uploadAndStoreImage($fileInput, $tableName, $columnName, $identifierColumn, $identifierValue) {
        if (!isset($_FILES[$fileInput]) || $_FILES[$fileInput]['error'] !== UPLOAD_ERR_OK) {
            return "Error uploading file.";
        }
    
        // Get file data
        $fileTmpPath = $_FILES[$fileInput]['tmp_name'];
        $fileType = mime_content_type($fileTmpPath);
        $allowedTypes = ['image/png'];
    
        if (!in_array($fileType, $allowedTypes)) {
            return "Invalid file type. Only PNG are allowed.";
        }
    
        // Read file content and convert it to binary
        $fileData = file_get_contents($fileTmpPath);
        if (!$fileData) {
            return "Failed to read file data.";
        }
    
        // Escape binary data to safely insert into SQL
        $escapedFileData = addslashes($fileData); 
    
        // Create an SQL query with the binary data properly formatted
        $query = "UPDATE $tableName SET $columnName = '$escapedFileData' WHERE $identifierColumn = '$identifierValue'";
    
        // Call DatabaseHandler with a single argument
        $queryResult = DatabaseHandler::make_modify_query($query);
    
        if ($queryResult === null) {
            return "Database update failed.";
        }

        return "Profile picture uploaded successfully!";
    }

}

?>

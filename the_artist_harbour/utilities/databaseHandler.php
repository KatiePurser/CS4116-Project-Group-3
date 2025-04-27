<?php

/**
 * Class DatabaseHandler
 *
 * This class provides methods for interacting with the database.
 */
class DatabaseHandler {

    private static $servername = "the-artist-harbour.cl64o2auodev.eu-north-1.rds.amazonaws.com";
    private static $username = "admin";
    private static $password = "password2025";
    private static $dbname = "artist_harbour_db";

    /**
     * Sets up a connection to the database.
     *
     * @return mysqli|null Returns a mysqli object if the connection was successfully established, otherwise null.
     */
    private static function setup_connection(): mysqli|null {
        $conn = new mysqli(static::$servername, static::$username, static::$password, static::$dbname);
        if ($conn->connect_error) {
            error_log("Connection failed: " . $conn->connect_error);
            return null;
        }
        return $conn;
    }

    /**
     * Executes a 'SELECT' query and returns the result as an array.
     *
     * @param string $query The SQL 'SELECT' query to execute.
     * @return array|null Returns an array with the result if the query was successful, where each element represents a single row; otherwise null.
     */
    public static function make_select_query($query): array|null {
        $conn = self::setup_connection();
        if ($conn === null) {
            return null;
        }
        try {
            $result = $conn->execute_query($query); // execute_query() is better and more secure than query(), throws an exception if the query fails
            $data = $result->fetch_all(MYSQLI_ASSOC); // always returns an array
        } catch (mysqli_sql_exception $exception) {
            error_log("Database error: " . $exception->getMessage());
            return null;
        } finally {
            $conn->close();
        }
        foreach ($data as &$row) {
            foreach ($row as $key => $value) {
                if (is_string($value)) {
                    $row[$key] = htmlspecialchars_decode($value, ENT_QUOTES);
                }
            }
        }
        return $data;
    }

    /**
     * Executes an 'INSERT', 'UPDATE' or 'DELETE' query and returns the number of affected (modified) rows.
     *
     * @param string $query The SQL 'INSERT', 'UPDATE' or 'DELETE' query to execute.
     * @return int|null Returns the number of affected rows if the query was successful; otherwise null.
     */
    public static function make_modify_query($query): int|null {
        $conn = self::setup_connection();
        if ($conn === null) {
            return null;
        }
        try {
            $conn->execute_query($query);
            $affected_rows = $conn->affected_rows;
        } catch (mysqli_sql_exception $exception) {
            echo("Database error: " . $exception->getMessage());
            return null;
        } finally {
            $conn->close();
        }
        return $affected_rows;
    }
    }

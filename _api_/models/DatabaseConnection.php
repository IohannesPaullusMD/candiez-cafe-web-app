<?php
class DatabaseConnection {

    public static function createConnection(): mysqli {
        $dbConn = mysqli_connect(
            $_ENV['DB_HOST'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASSWORD'],
            $_ENV['DB_NAME']
        );

        if (!$dbConn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        // Set charset to ensure proper encoding
        mysqli_set_charset($dbConn, 'utf8mb4');
        return $dbConn;
    } 
}

?>

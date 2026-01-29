<?php
    declare(strict_types=1);

    function getPdo(): PDO{
        
        $host = "127.0.0.1"; 
        $db = "hotel_app";
        $user = "root";
        $password = "";
        $charset = "utf8mb4";

        $log = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
            ];

        return new PDO($log,$user,$password,$options);

    }

?>   
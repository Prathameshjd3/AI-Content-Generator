<?php
    $host = "localhost";
    $username = "root";
    $password = "Admin$123";
    $database = "ai_generator";

    $db = new mysqli($host, $username, $password, $database);

    if($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
    // else {
    //     echo "Connected successfully to the database.";
    // }   
?>
<?php
    $host = 'localhost';
    $user = 'root';
    $pass = '';

    try{
        $conn = new PDO ("mysql:host=$host", $user, $pass);
        $sql = "Create database testdb1";
        $conn-.exec($sql);
        echo "Database is created succesfully";
    }catch(Exception $e){
        echo "Database is not created, something went wrong!";
    }
?>
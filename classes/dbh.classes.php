<?php

class Dbh {
  
    protected function connect(){
       try{
        $host = "localhost";
        $port = "3310";
        $dbname = "bookstore";
        $username = "root";
        $password = "";
        $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
        //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
       }catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
        die();
       }
    }
    }

?>

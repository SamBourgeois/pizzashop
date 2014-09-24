<?php
require_once("../src/config/dbconfig.php");
abstract class AbstractDAO{
    public function getDb(){
        $db = new PDO('mysql:host=' . DBConfig::$host . ';dbname=' . DBConfig::$dbName, DBConfig::$dbUser, DBConfig::$dbPassw);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
        return $db;
    }
}
?>
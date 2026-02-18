<?php

// Fonction qui connecte PDO à la base de données et retourne l'objet PDO connecté
function connectToDB() {
    $dsn = "mysql:host=db.3wa.io;port=3306;dbname=lukatrehout_akinator;charset=utf8";
    
    $db = new PDO($dsn,"lukatrehout", "872c9df53a4d151ccc68bc096323ab7b");
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    return $db;
}
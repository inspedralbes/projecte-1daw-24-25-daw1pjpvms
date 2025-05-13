<?php
//Mysql
$servername = "db";
$username = "usuari";
$password = "paraula_de_pas";
$dbname = "a24pauvermac_incidencies";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error en la connexió amb la base de dades: " . $conn->connect_error);
    
}

//MongoDB

require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://root:example@mongo:27017");

$collection = $client->demo->users;
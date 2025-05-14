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


require 'vendor/autoload.php';

$uri = "mongodb+srv://a24marsuaber:masube13@cluster0.ai2nqhr.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";

$client = new MongoDB\Client($uri);

$collection = $client->demo->users;
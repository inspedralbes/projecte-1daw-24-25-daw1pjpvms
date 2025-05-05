<?php
$servername = "db";
$username = "usuari";
$password = "paraula_de_pass";
$dbname = "a24pauvermac_incidencies";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error en la connexió amb la base de dades: " . $conn->connect_error);
}
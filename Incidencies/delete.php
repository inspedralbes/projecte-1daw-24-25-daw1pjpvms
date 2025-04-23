<?php

$servername = "localhost";
$username = "a24pauvermac_dawpaula";
$password = "%NwAi7&0h104w|lM";
$dbname = "a24pauvermac_daw";

?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <title>Borrar</title>
</head>

<body>
    <?php
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error en la connexió amb la base de dades: " . $conn->connect_error);
    }

    if (!isset($_GET['id'])) {
        die("<h1 id='informacio'>No s'ha indicat cap persona per esborrar</h1>");
    }

    $sql = "DELETE FROM PERSONES WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_GET['id']);

    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }
    ?>

    <div class="phpcuadre">
        <?php

        if ($stmt->affected_rows > 0) {

            echo "<h1>Esborrat $stmt->affected_rows elements </h1>";
        } else {
            echo "<h1>No s'ha eliminat cap inscrit</h1>";
        }
        $conn->close();
        ?>
        <a href="llistat.php">Tornar al llistat</a>
    </div>


</body>
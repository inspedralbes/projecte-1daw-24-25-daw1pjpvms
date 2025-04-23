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
  <title>Document</title>
</head>

<body>

  <?php
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT id, nom, mail FROM PERSONES";

  $stmt = $conn->prepare($sql);
  if (!$stmt->execute()) {
    die("Error executing statement: " . $stmt->error);
  }
  $result = $stmt->get_result();
  echo "<div class = 'phpcuadre'>";

  if ($result->num_rows > 0) {
    echo "<h1>Llistat d'inscrits</h1>";
    echo "<ul>";

    while ($row = $result->fetch_assoc()) {
      echo " <li> " . "ID: " . $row["id"] . " Nom: " . $row["nom"] . " Email: " . $row["mail"] . "<a href='action.php?id=" . $row["id"] . "' title='editar' >Editar</a>" . "<a href='delete.php?id=" . $row["id"] . "' title='esborrar' >Esborrar</a>" . "</li>";
    }
    echo "</ul>";
  } else {
    echo "No hi ha inscrits";
  }

  $conn->close();

  ?>

  <a href="action.php">Tornar al inici</a>
  </div>


</body>
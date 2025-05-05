<?php
$servername = "db";
$username = "usuari";
$password = "user123";
$dbname = "a24pauvermac_incidencies";
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
      die("Error en la connexió amb la base de dades: " . $conn->connect_error);
  }

  $sql = "SELECT Dept, Descripcio FROM INCIDENCIA";

  $stmt = $conn->prepare($sql);
  if (!$stmt->execute()) {
    die("Error executing statement: " . $stmt->error);
  }
  $result = $stmt->get_result();
  

  if ($result->num_rows > 0) {
    echo "<h1>Llistat d'incidencies</h1>";
    echo "<ul>";

    while ($row = $result->fetch_assoc()) {
      echo " <li> " . "Dept: " . $row["Dept"] . " Descripcio: " . $row["Descripcio"] . "</li>";
    }
    echo "</ul>";
  } else {
    echo "No hi ha inscrits";
  }

  $conn->close();

  ?>

  <a href="index.html ">Tornar al inici</a>
  </div>


</body>
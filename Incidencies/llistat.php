<?php
require "conexio.php";
include "funciones.php";
?>
<!DOCTYPE html>
<html lang="ca">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <title>Llistat d'incidències</title>
  <link rel="icon" type="image/png" href="icona.png">

</head>


<body>

  <?php
  $User = 'Administrador';
  $data = date('Y-m-d H:i:s');
  $ipUsuari = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
  $pageUsuari = 'Llistat Incidencies';
  $navegador = $_SERVER['HTTP_USER_AGENT'];
  guardarLog($collection, $User, $data, $ipUsuari, $pageUsuari, $navegador);

  llegirIncidenciesllista($conn);

  $conn->close();
  ?>

</body>

</html>
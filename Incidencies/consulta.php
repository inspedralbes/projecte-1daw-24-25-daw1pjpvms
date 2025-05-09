<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consulta d'incidències</title>
  <link rel="stylesheet" href="estilos2.css">
  <style>
    table {
      width: 80%;
      border-collapse: collapse;
      margin: 20px auto;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
  </style>
<?php
require "conexio.php";
include "funciones.php";

$codi = $_POST['codi'] ?? '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  llegirConsulta($conn, $codi);
  die;
}
?>


</head>
<body>

  <header class="banner">
    <h1 class="bigtitol">Consulta d'incidències</h1>
  </header>

  <main class="contenidor">
    <h2 class="subtitol">Introdueix el teu codi d'incidència</h2> 

    <div class="forms">
      <form action="" method="POST">
        <label for="codi">Codi d'incidència:</label>
        <input type="text" id="codi" name="codi" placeholder="Ex: INC12345" required>

        <button class="button type1" type="submit">
          <span class="btn-txt">CONSULTAR</span>
        </button>
      </form>
    </div>
  </main>

</body>
</html>

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

$codi = $_POST['codi'] ?? '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
  
  
  function llegirEstat($conn, $codi_estat) {
    $sql = "SELECT nom FROM ESTAT WHERE cod_estat = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $codi_estat);

    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }

    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return $row["nom"];
    } else {
        return "Desconegut";
    }
  }
  function llegirConsulta($conn, $codi) {

    $sql = "SELECT Dept, Descripcio, cod_estat FROM INCIDENCIA WHERE Id =$codi";
    $stmt = $conn->prepare($sql);

    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h1 style='text-align:center;'>Estat de la teva consulta</h1>";
        echo "<table>";
        echo "<tr><th>Departament</th><th>Descripció</th><th>Estat</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $nomEstat = llegirEstat($conn, $row["cod_estat"]);
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["Dept"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["Descripcio"]) . "</td>";
            echo "<td>" . htmlspecialchars($nomEstat) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
          

    } else {
        echo "<p style='text-align:center;'>No hi ha inscrits</p>";
    }
  }

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

<?php
require "conexio.php";
?>
<!DOCTYPE html>
<html lang="ca">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
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
</head>

<body>

  <?php

  llegirIncidencies($conn);

  function llegirIncidencies($conn) {
    $sql = "SELECT Id, cod_dept, Descripcio, Data, cod_estat, cod_tecnic,prioritat FROM INCIDENCIA";
    $stmt = $conn->prepare($sql);

    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h1 style='text-align:center;'>Llistat d'incidències</h1>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Departament</th><th>Descripció</th><th>Data</th><th>Técnic</th><th>Prioritat</th><th>Estat</th><th>Opcions</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $nomEstat = llegirEstat($conn, $row["cod_estat"]);
            $LlegirDept = llegirDept($conn, $row["cod_dept"]);
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["Id"]) . "</td>"; 
            echo "<td>" . htmlspecialchars($LlegirDept) . "</td>";
            echo "<td>" . htmlspecialchars($row["Descripcio"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["Data"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["cod_tecnic"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["prioritat"]) . "</td>";
            echo "<td>" . htmlspecialchars($nomEstat) . "</td>";
            echo "<td> <a href='llistat.php' id='admin'>Editar</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>No hi ha inscrits</p>";
    }
  }

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
  function llegirDept($conn, $codi_dept) {
    $sql = "SELECT nom FROM DEPARTAMENT WHERE cod_dept = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $codi_dept);

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

  $conn->close();
  ?>

  <div style="text-align:center; margin-top:20px;">
    <a href="index.html">

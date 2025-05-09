<?php
require "conexio.php";

$id = $_POST['id'] ?? null;
$incidencia = null;
$tecnic = $_POST['tecnic'] ?? null;
$prori = $_POST['proritat'] ?? null;  
$estat = $_POST['estat'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $id = htmlspecialchars(trim($_POST['id']));
   
    if (!empty($estat)) {
        actualitzarEstat($conn, $id, $estat);  
    }

}


function actualitzarEstat($conn, $id, $estat) {
    $sql = "UPDATE INCIDENCIA SET cod_estat = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("ii", $estat, $id);

    if (!$stmt->execute()) {
        echo "<p style='color:red;'>Error al modificar estat: " . $stmt->error . "</p>";
    }
   

    $stmt->close();
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
function llegirIncidencies($conn, $id) {
    if ($id === null) {
        echo "<p style='text-align:center;'>No hi ha cap ID proporcionat</p>";
        return;
    }

    $sql = "SELECT Id, cod_dept, Descripcio, Data, cod_estat, cod_tecnic, prioritat 
            FROM INCIDENCIA 
            WHERE cod_tecnic = ? AND cod_estat IN('1','2')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Departament</th><th>Descripció</th><th>Data</th><th>Técnic</th><th>Prioritat</th><th>Estat</th></tr>";
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
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>No hi ha inscrits</p>";
    }

    $stmt->close();
}

  llegirIncidencies($conn,$id);

?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Formulari d'incidències</title>

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

    <div class="banner">
        <h1 class="bigtitol">Modificació d'incidencies</h1>
    </div>
    <form action="" method="post">

            <div>
            <label for="id">el teu id de tecnic: <span class="boto"> </span></label>
           <textarea class="insert" id="id" name="id" placeholder="Introdueix el teu ID"><?= htmlspecialchars($id ?? '') ?></textarea>
            <button class="button type1" type="submit">
                <span class="btn-txt">Envia</span>
            </div>
            <div>
            <label for="proritat">Estat: <span class="boto"></span></label>
            <select name="estat" id="estat">
                <option value=""> Selecciona un estat </option>
                <option value="1" <?= $estat == '1' ? 'selected' : '' ?>>En espera</option>
                <option value="2" <?= $estat == '2' ? 'selected' : '' ?>>Revisant</option>
                <option value="3" <?= $estat == '3' ? 'selected' : '' ?>>Solucionada</option>
            
               
            </select>
           
               
           
            <button type='submit' class='edit-btn'>Enviar canvis</button>
        

            </div>
        </form>
        <p><a href='./'>Tornar a la pàgina principal</a></p>
        <a href="llistat.php">Espai de control</a>

</body>
</html>

<?php
function actualitzarEstat($conn, $id, $estat) {
    $sql = "UPDATE INCIDENCIA SET cod_estat = ? WHERE Id = ?";
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

function llegirIncidenciesTecnics($conn, $id) {
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

function llegirIncidenciaPerId($conn, $id) {
    $sql = "SELECT Id, cod_dept, Descripcio, Data, cod_estat, cod_tecnic,prioritat FROM INCIDENCIA WHERE Id = ? AND cod_estat IN('1','2')";
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
}

function guardarIncidencia($conn, $departament, $descripcio, $data, $estat, $codtec, $proritat) {
    $sql = "INSERT INTO INCIDENCIA (cod_dept, Descripcio, Data, cod_estat, cod_tecnic, prioritat) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiis", $departament, $descripcio, $data, $estat, $codtec, $proritat );

    if (!$stmt->execute()) {
        die("Error en la consulta: " . $stmt->error);
    }

    $stmt->close();
}

function llegirId($conn, $data) {
    $sql = "SELECT Id FROM INCIDENCIA WHERE Data = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $data);

    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }

    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return $row["Id"];
    } else {
        return "000";
    }
}

function actualitzarTecnic($conn, $id, $tecnic) {
    $sql = "UPDATE INCIDENCIA SET cod_tecnic = ? WHERE Id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("si", $tecnic, $id);

    if (!$stmt->execute()) {
        echo "<p style='color:red;'>Error al modificar tècnic: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

function actualitzarPrioritat($conn, $id, $prori) {
    $sql = "UPDATE INCIDENCIA SET prioritat = ? WHERE Id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("si", $prori, $id);

    if (!$stmt->execute()) {
        echo "<p style='color:red;'>Error al modificar prioritat: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
  function llegirConsulta($conn, $codi) {

    $sql = "SELECT cod_dept, Descripcio, cod_estat FROM INCIDENCIA WHERE Id =$codi";
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
            $nomDept = llegirDept($conn, $row["cod_dept"]);
            echo "<tr>";
            echo "<td>" . htmlspecialchars($nomDept) . "</td>";
            echo "<td>" . htmlspecialchars($row["Descripcio"]) . "</td>";
            echo "<td>" . htmlspecialchars($nomEstat) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
          

    } else {
        echo "<p style='text-align:center;'>No hi ha inscrits</p>";
    }
  }
  function llegirIncidenciesllista($conn) {
    $sql = "SELECT Id, cod_dept, Descripcio, Data, cod_estat, cod_tecnic,prioritat FROM INCIDENCIA WHERE cod_estat IN('1','2')";
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
          
  echo "<td>
  <form action='administ.php' method='post'>
    <input type='hidden' name='id' value='" . htmlspecialchars($row['Id']) . "'>
    <button type='submit' class='edit-btn'>Editar</button>
  </form>
</td>";

            echo "</tr>";
            
        }
        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>No hi ha inscrits</p>";
    }
  }
  function llegirIncidenciesAdminist($conn, $id) {
    $sql = "SELECT Id, cod_dept, Descripcio, Data, cod_estat, cod_tecnic,prioritat FROM INCIDENCIA WHERE Id = $id AND cod_estat IN('1','2')";
    $stmt = $conn->prepare($sql);

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
  }
?>
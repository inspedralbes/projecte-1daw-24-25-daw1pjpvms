
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
        echo "<br><h1 style='text-align:center;'>Estat de la teva consulta</h1>";
        echo "<div class='container mt-4'>";
        echo "<div class='p-3 bg-light border rounded'>";
        echo "<table class='table table-striped'>";
        echo "<tr><th>Departament</th><th>Descripció</th><th>Estat</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $nomEstat = llegirEstat($conn, $row["cod_estat"]);
            $styleEstat = "";
            if ($row["cod_estat"] == 1) {
                $styleEstat = "color: red; font-weight: bold;";
            } elseif ($row["cod_estat"] == 2) {
                $styleEstat = "color: orange;";
            } elseif ($row["cod_estat"] == 3) {
                $styleEstat = "color: green;";
            }

            $nomDept = llegirDept($conn, $row["cod_dept"]);
            echo "<tr>";
            echo "<td>" . htmlspecialchars($nomDept) . "</td>";
            echo "<td>" . htmlspecialchars($row["Descripcio"]) . "</td>";
            echo "<td style='$styleEstat'>" . htmlspecialchars($nomEstat) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
        echo "</div>";


    } else {
        echo "<p style='text-align:center;'>No hi ha inscrits</p>";
    }
  }
  function llegirIncidenciesllista($conn) {
    $sql = "SELECT Id, cod_dept, Descripcio, Data, cod_estat, cod_tecnic,prioritat,data_ini_sol FROM INCIDENCIA WHERE cod_estat IN('1','2')";
    $stmt = $conn->prepare($sql);

    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h1 style='text-align:center;'>Llistat d'incidències</h1>";
        echo "<div class='container mt-4'>";
        echo "<div class='p-3 bg-light border rounded'>";
        echo "<table class='table table-striped'>";
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
    <input type='hidden' name='dataini' value='" . htmlspecialchars($row['data_ini_sol'] ?? '') . "'>

    <button type='submit' class='btn btn-outline-success'>Editar</button>
  </form>
</td>";

            echo "</tr>";
            
        }
        echo "</table>";
        echo "</div>";
        echo "</div>";

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
        echo "<p><h1 style='text-align:center;'>Llistat d'incidències</h1>";
        echo "<div class='container mt-4'>";
        echo "<div class='p-3 bg-light border rounded'>";
        echo "<table class='table table-striped'>";
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
        echo "</div>";
        echo "</div>";
    } else {
        echo "<p style='text-align:center;'>No hi ha inscrits</p>";
    }
  }
  function llegirIdTec($conn, $id) {
    $sql = "SELECT Id FROM INCIDENCIA WHERE cod_tecnic = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);

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
function guardarActu($conn, $id, $idincidencia, $descripcio, $visible, $temps) {
    $sql = "INSERT INTO ACTUACIONS (cod_tecnic, cod_inci, descri, mostrar, temps) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisii",$id, $idincidencia, $descripcio, $visible, $temps );

    if (!$stmt->execute()) {
        die("Error en la consulta: " . $stmt->error);
    }

    $stmt->close();
}
function llegirActu($conn, $idincidencia) {
    $sql = "SELECT cod_inci, descri, temps FROM ACTUACIONS WHERE cod_inci = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idincidencia);

    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        echo "<table class='incidencies-table'>";
        echo "<tr><th>Id Incidència</th><th>Descripció</th><th>Temps (min)</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["cod_inci"]) . "</td>"; 
            echo "<td>" . htmlspecialchars($row["descri"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["temps"]) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>No hi ha actuacions registrades.</p>";
    }
}

function llegirIncidenciesTecnics($conn, $id) {
    if ($id === null) {
        echo "<p style='text-align:center;'>No hi ha cap ID proporcionat</p>";
        return;
    }

    $sql = "SELECT Id, cod_dept, Descripcio, Data, cod_estat, cod_tecnic, prioritat, data_ini_sol
            FROM INCIDENCIA 
            WHERE cod_tecnic = ? AND cod_estat IN('1','2')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table class='incidencies-table'>
                <tr>
                    <th>ID</th>
                    <th>Departament</th>
                    <th>Descripció</th>
                    <th>Data</th>
                    <th>Tècnic</th>
                    <th>Prioritat</th>
                    <th>Estat</th>
                    <th>Data inici</th>
                    <th>Accions</th>
                </tr>";

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
            echo "<td>" . htmlspecialchars($row["data_ini_sol"]) . "</td>";
            echo "<td>
                    <form action='actuacions.php' method='post'>
                        <input type='hidden' name='id' value='" . htmlspecialchars($row['cod_tecnic']) . "'>
                        <input type='hidden' name='idincidencia' value='" . htmlspecialchars($row['Id']) . "'>
                        <button type='submit' class='edit-btn'>Afegir actuacions</button>
                    </form>
                </td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>No hi ha incidències disponibles per a aquest ID de tècnic.</p>";
    }

    $stmt->close();
}

function llegirActuUsu($conn, $idincidencia) {
    $sql = "SELECT cod_inci, descri,temps FROM ACTUACIONS WHERE cod_inci = ? AND mostrar = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idincidencia);

    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<div class='container mt-4'>";
        echo "<div class='p-3 bg-light border rounded'>";
        echo "<b> Comentaris progrés: </b><p>";
        echo "<table class='table table-striped'>";
        echo "<tr><th>Descripcio</th></tr>";
        while ($row = $result->fetch_assoc()) {
            
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["descri"]) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>No hi ha inscrits</p>";
    }
    echo "<a href='./' class='btn btn-secondary me-2'>Tornar a la pàgina principal</a>";
    echo "</div>"; 
    echo "</div>";
}
function dataIniAct($conn, $id, $dataini) {
    $sql = "UPDATE INCIDENCIA SET data_ini_sol = ? WHERE Id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("si", $dataini, $id);

    if (!$stmt->execute()) {
        echo "<p style='color:red;'>Error al modificar data: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
function dataFiAct($conn, $id, $datafi) {
    $sql = "UPDATE INCIDENCIA SET data_fi_sol = ? WHERE Id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("si", $datafi, $id);

    if (!$stmt->execute()) {
        echo "<p style='color:red;'>Error al modificar data: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
?>
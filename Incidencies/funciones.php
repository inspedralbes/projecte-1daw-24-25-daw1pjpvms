
<?php
function actualitzarEstat($conn, $id, $estat)
{
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

function llegirEstat($conn, $codi_estat)
{
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

function llegirDept($conn, $codi_dept)
{
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

function llegirIncidenciaPerId($conn, $id)
{
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
        echo "<p style='text-align:center;'>No hi ha incidenciès</p>";
    }
}

function guardarIncidencia($conn, $departament, $descripcio, $data, $estat, $codtec, $proritat)
{
    $sql = "INSERT INTO INCIDENCIA (cod_dept, Descripcio, Data, cod_estat, cod_tecnic, prioritat) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiis", $departament, $descripcio, $data, $estat, $codtec, $proritat);

    if (!$stmt->execute()) {
        die("Error en la consulta: " . $stmt->error);
    }

    $stmt->close();
}

function llegirId($conn, $data)
{
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

function actualitzarTecnic($conn, $id, $tecnic)
{
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


function actualitzarPrioritat($conn, $id, $prori)
{
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
function llegirConsulta($conn, $codi)
{

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
        echo "<p style='text-align:center;'>No hi ha consultes</p>";
    }
}
function llegirIncidenciesllista($conn)
{
    $sql = "SELECT Id, cod_dept, Descripcio, Data, cod_estat, cod_tecnic,prioritat,data_ini_sol FROM INCIDENCIA WHERE cod_estat IN('1','2')ORDER BY `data` DESC";
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
        echo "<a href='./' class='btn btn-secondary me-2'>Tornar a la pàgina principal</a>";
        echo "</div>";
        echo "</div>";
    } else {
        echo "<p style='text-align:center;'>No hi ha incidenciès</p>";
    }
}
function llegirIncidenciesAdminist($conn, $id)
{
    $sql = "SELECT Id, cod_dept, Descripcio, Data, cod_estat, cod_tecnic,prioritat FROM INCIDENCIA WHERE Id = $id AND cod_estat IN('1','2') ORDER BY `data` DESC";
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
        echo "<p style='text-align:center;'>No hi ha incidenciès</p>";
    }
}
function llegirIdTec($conn, $id)
{
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
function guardarActu($conn, $id, $idincidencia, $descripcio, $visible, $temps, $data)
{
    $sql = "INSERT INTO ACTUACIONS (cod_tecnic, cod_inci, descri, mostrar, temps, `data`) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisiis", $id, $idincidencia, $descripcio, $visible, $temps, $data);

    if (!$stmt->execute()) {
        die("Error en la consulta: " . $stmt->error);
    }

    $stmt->close();
}

function llegirActu($conn, $idincidencia)
{
    $sql = "SELECT cod_inci, descri, temps FROM ACTUACIONS WHERE cod_inci = ? ";
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

function llegirIncidenciesTecnics($conn, $id)
{
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
            echo "<td>" . htmlspecialchars($row["data_ini_sol"] ?? '-') . "</td>";
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

function llegirActuUsu($conn, $idincidencia)
{
    $sql = "SELECT cod_inci, descri, temps, `data`
            FROM ACTUACIONS
            WHERE cod_inci = ? AND mostrar = 1
            ORDER BY `data` DESC";

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
        echo "<tr><th>Descripció</th><th>Data</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["descri"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["data"]) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>No hi han comentaris</p>";
    }
    echo "<a href='./' class='btn btn-secondary me-2'>Tornar a la pàgina principal</a>";
    echo "</div>";
    echo "</div>";
}

function dataIniAct($conn, $id, $dataini)
{
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
function dataFiAct($conn, $id, $datafi)
{
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
function guardarLog($collection, $User, $dataUsuari, $ipUsuari, $pageUsuari, $user_agent)
{
    $collection->insertOne([
        'User' => $User,
        'Data' => $dataUsuari,
        'ip_origin' => $ipUsuari,
        'pagina visitada' => $pageUsuari,
        'navegador' => $user_agent

    ]);
}

function llegirDadesMongodb($collection)
{
    $documents = $collection->find();

    echo "<div class='container mt-4'>";
    echo "<h1> Dades MongoDB del gestor </h1>";
    echo "<div class='p-3 bg-light border rounded'>";
    echo "<table class='table table-striped'>";
    echo "<tr><th>Usuari</th><th>Data</th><th>Pàgina visitada</th><th>Navegador</th></tr>";

    foreach ($documents as $document) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($document['User'] ?? "x") . "</td>";
        echo "<td>" . htmlspecialchars($document['Data'] ?? "x") . "</td>";
        echo "<td>" . htmlspecialchars($document['pagina visitada'] ?? "x") . "</td>";
        echo "<td>" . htmlspecialchars($document['navegador'] ?? "x") . "</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "<a href='./' class='btn btn-secondary me-2'>Tornar a la pàgina principal</a>";
    echo "</div>";
    echo "</div>";
}
function llegirInformeTec($conn)
{
    $sql = "SELECT 
        I.Id AS ID_Incidencia,
        T.rol AS Tecnic,
        T.nom AS Nom,
        I.prioritat AS Prioritat,
        I.Data AS Data_Inici,
        SUM(A.temps) AS Temps_Total
    FROM 
        INCIDENCIA I
    INNER JOIN 
        TECNICS T ON I.cod_tecnic = T.cod_tecnic
    INNER JOIN 
        ACTUACIONS A ON I.Id = A.cod_inci
    INNER JOIN 
        ESTAT E ON I.cod_estat = E.cod_estat
    WHERE 
        E.nom != 'Solucionada'
    GROUP BY 
        I.Id, T.rol, T.nom,I.Data, I.prioritat
    ORDER BY 
        T.rol, I.prioritat;
    ";

    $stmt = $conn->prepare($sql);

    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<div class='container mt-4'>";
        echo "<div class='p-3 bg-light border rounded'>";
        echo "<h1> Tècnics </h1>";
        $tecnicAnterior = null;
        while ($row = $result->fetch_assoc()) {
            $tecnicActual = $row["Tecnic"] . " - " . $row["Nom"];
            if ($tecnicActual !== $tecnicAnterior) {
                if ($tecnicAnterior !== null) {
                    echo "</table><br>";
                }
                echo "<h4>Tècnic: " . htmlspecialchars($row["Tecnic"]) . " (" . htmlspecialchars($row["Nom"]) . ")</h4>";
                echo "<table class='table table-striped'>";
                echo "<tr><th>ID Incidéncia</th><th>Prioritat</th><th>Data Inici</th><th>Temps Total</th></tr>";
                $tecnicAnterior = $tecnicActual;
            }


            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["ID_Incidencia"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["Prioritat"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["Data_Inici"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["Temps_Total"]) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";
    } else {
        echo "<p style='text-align:center;'>No hi ha dades</p>";
    }
}

function llegirDeptInfo($conn)
{
    $sql = "SELECT
  D.nom AS Departament,
  (SELECT COUNT(*)
     FROM INCIDENCIA I
     WHERE I.cod_dept = D.cod_dept
  ) AS Nombre_Incidencies,
  (SELECT SUM(A.temps)
     FROM INCIDENCIA I2
     JOIN ACTUACIONS A ON A.cod_inci = I2.Id
     WHERE I2.cod_dept = D.cod_dept
  ) AS Temps_Total
FROM DEPARTAMENT D;";
    $stmt = $conn->prepare($sql);

    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        echo "<div class='p-3 bg-light border rounded'>";
        echo "<h1>Departaments</h1>";

        $departamentAnterior = null;

        while ($row = $result->fetch_assoc()) {
            $departamentActual = $row["Departament"];

            if ($departamentActual !== $departamentAnterior) {
                if ($departamentAnterior !== null) {
                    echo "</table><br>";
                }

                echo "<h4>Departament: " . htmlspecialchars($row["Departament"]) . "</h4>";
                echo "<table class='table table-striped'>";
                echo "<tr><th>Nombre d'incidències</th><th>Temps total dedicat (minuts)</th></tr>";

                $departamentAnterior = $departamentActual;
            }

            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["Nombre_Incidencies"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["Temps_Total"]) . "</td>";
            echo "</tr>";
        }

        echo "</table>";

        echo "<a href='./' class='btn btn-secondary me-2 mt-3'>Tornar a la pàgina principal</a>";
        echo "</div>";
    }
}
function mostraFooter()
{
    echo "<footer> <p> Paula Vera | Marcos Suárez | Institut Pedralbes | 2025 </p></footer>";
}
function mostraHeader($apartat)
{
    echo "<header class='banner'>";
    echo "<h1 class='bigtitol'>$apartat</h1>";
    echo "</header> ";
}

?>
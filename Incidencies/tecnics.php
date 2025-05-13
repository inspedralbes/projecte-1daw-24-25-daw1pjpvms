<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Formulari d'incidències</title>
    <link rel="stylesheet" href="estilos.css">

</head>
<body>

    <div class="banner">
        <h1 class="bigtitol">Estat d'incidències</h1>
    </div>

    <form action="" method="post">
        <div>
            <label for="id">El teu id de tècnic:</label>  
            <textarea class="insert" id="id" name="id" placeholder="Introdueix el teu ID"><?= htmlspecialchars($id ?? '') ?></textarea>
            <button class="button type1" type="submit" name="submit_id">
                <span class="btn-txt">Envia ID</span>
            </button>
        </div>
        <br>
    </form>

</body>
</html>
<?php
require "conexio.php";
include "funciones.php";

$id = $_POST['id'] ?? null;
$descripcio = $_POST['descripcio'] ?? null;
$estat = $_POST['estat'] ?? null;
$temps = $_POST['temps'] ?? null;
$visible = $_POST['visible'] ?? null;
$User = 'Tecnic';
$data = date('Y-m-d H:i:s');
$ipUsuari = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$pageUsuari = 'Consulta Incidencies tecnics';
  guardarLog($collection, $User, $data, $ipUsuari ,$pageUsuari);
  
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  
    if (isset($_POST['submit_id'])) {
        $id = htmlspecialchars(trim($_POST['id']));
        if (!empty($id)) {
        
            llegirIncidenciesTecnics($conn, $id);
        }
    }
    
    
}
?>

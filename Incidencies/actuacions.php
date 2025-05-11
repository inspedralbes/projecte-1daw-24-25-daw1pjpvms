<?php
require "conexio.php";
include "funciones.php";

$id = $_POST['id'] ?? null;
$descripcio = $_POST['descripcio'] ?? null;
$estat = $_POST['estat'] ?? null;
$temps = $_POST['temps'] ?? null;
$visible = $_POST['visible'] ?? null;
$idincidencia = $_POST['idincidencia'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['submit_actuacio'])) {

        
        if (!empty($estat)) {
            actualitzarEstat($conn, $idincidencia, $estat);  
        }

        if (!empty($descripcio)) {
            guardarActu($conn, $id, $idincidencia, $descripcio, $visible, $temps);  
        }

        
    }
    llegirActu($conn, $idincidencia); 
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Formulari d'actuació</title>
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
        <h1 class="bigtitol">Actuació de la incidència</h1>
    </div>

    <form action="" method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id ?? '') ?>">
        <input type="hidden" name="idincidencia" value="<?= htmlspecialchars($idincidencia ?? '') ?>">
        <div>
            <label for="descripcio">Descripció de l'actuació (màx. 500 caràcters):</label><br>  
            <textarea id="descripcio" name="descripcio" maxlength="500" placeholder="Escriu una descripció curta" required><?= htmlspecialchars($descripcio ?? '') ?></textarea><br>  

            <label for="visible">Visible per l'usuari:</label>
            <input type="checkbox" id="visible" name="visible" value="1"><br><br> 

            <label for="temps">Temps:</label><br>
            <textarea id="temps" name="temps" maxlength="10" placeholder="Introdueix el temps invertit en minuts" required><?= htmlspecialchars($temps ?? '') ?></textarea><br><br>

            <label for="estat">Estat:</label>
            <select name="estat" id="estat" required>
                <option value=""> Selecciona un estat </option>
                <option value="1" <?= $estat == '1' ? 'selected' : '' ?>>En espera</option>
                <option value="2" <?= $estat == '2' ? 'selected' : '' ?>>Revisant</option>
                <option value="3" <?= $estat == '3' ? 'selected' : '' ?>>Solucionada</option>
            </select><br><br>

            <button type="submit" name="submit_actuacio" class="edit-btn">Envia actuació</button>
        </div>
    </form>

    <p><a href='./'>Tornar a la pàgina principal</a></p>
    <a href="llistat.php">Espai de control</a>

</body>
</html>

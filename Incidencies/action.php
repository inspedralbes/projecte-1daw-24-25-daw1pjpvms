<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Formulari d'incidències</title>
    <link rel="stylesheet" href="estilos.css">
   
    <style>
        textarea {
            width: 100%;
            resize: none; 
            padding: 8px;
            font-size: 1em;
            box-sizing: border-box;
        }

        select {
            width: 100%;
            padding: 8px;
            font-size: 1em;
            box-sizing: border-box;
        }
    </style>
</head>
<?php

require "conexio.php";
include "funciones.php";

$departament = $_POST['departament'] ?? '';
$descripcio = $_POST['descripcio'] ?? '';
$departamentErr = '';
$descripcioErr = '';
$errors = -1;
$data = date('Y-m-d H:i:s');
$estat = 1;
$codtec = 0;
$proritat = 'Sense asignar';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = 0;

    if (empty($departament)) {
        $departamentErr = "Has de seleccionar un departament.";
        $errors++;
    }

    if (empty($descripcio)) {
        $descripcioErr = "La descripció és obligatòria.";
        $errors++;
    } elseif (strlen($descripcio) > 200) {
        $descripcioErr = "La descripció no pot superar els 200 caràcters.";
        $errors++;
    }

    if ($errors == 0) {

        
        guardarIncidencia($conn, $departament, $descripcio, $data, $estat, $codtec, $proritat);
        $idllegit = llegirId($conn, $data);
     

        echo "<div class='phpcuadre2'>";
        echo "<p><strong>Departament:</strong> $departament</p>";
        echo "<p><strong>Descripció:</strong> $descripcio</p>";
        echo "<p id='important'><strong >ID de consulta:</strong> $idllegit</p>";
        echo "<b><a href='./'>Tornar a la pàgina principal</a></b>";
        echo "</div>";
        
        die;
    }
}




?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Formulari d'incidències</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        textarea {
            width: 100%;
            resize: none; 
            padding: 8px;
            font-size: 1em;
            box-sizing: border-box;
        }

        select {
            width: 100%;
            padding: 8px;
            font-size: 1em;
            box-sizing: border-box;
        }
    </style>
</head>

<body>

    <div class="banner">
        <h1 class="bigtitol">Formulari d'incidències</h1>
    </div>

    <div>
        <form action="" method="post">
            <?php if ($errors > 0): ?>
                <div class='error'>ATENCIÓ: Hi ha <?= $errors ?> error(s) en el formulari</div>
            <?php endif; ?>

            <label for="departament">Departament: <span class="boto"><?= $departamentErr ?></span></label>
            <select name="departament" id="departament">
                <option value="">-- Selecciona un departament --</option>
                <option value="1" <?= $departament == '1' ? 'selected' : '' ?>>Angles</option>
                <option value="2" <?= $departament == '2' ? 'selected' : '' ?>>Fisica</option>
                <option value="3" <?= $departament == '3' ? 'selected' : '' ?>>Llengua catalana</option>
                <option value="4" <?= $departament == '4' ? 'selected' : '' ?>>Matematiques</option>
                
               
            </select>

            <label for="descripcio">Descripció de la incidència (màx. 200 caràcters): <span class="boto"><?= $descripcioErr ?></span></label>
            <textarea class="insert" id="descripcio" name="descripcio" rows="5" maxlength="200" placeholder="Escriu una descripció curta"><?= htmlspecialchars($descripcio) ?></textarea>

            <button class="button type1" type="submit">
                <span class="btn-txt">Envia</span>
            </button>
        </form>
    </div>

</body>
</html>
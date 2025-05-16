<?php
require "conexio.php";
include "funciones.php";

$id = $_POST['id'] ?? null;
$descripcio = $_POST['descripcio'] ?? null;
$estat = $_POST['estat'] ?? null;
$temps = $_POST['temps'] ?? null;
$visible = $_POST['visible'] ?? null;
$idincidencia = $_POST['idincidencia'] ?? null;
$datafi = $_POST['datafi'] ?? null;
$User = 'Tecnic';
$data = date('Y-m-d H:i:s');
$ipUsuari = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$pageUsuari = 'Actuacions';

guardarLog($collection, $User, $data, $ipUsuari ,$pageUsuari);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     

    if (isset($_POST['submit_actuacio'])) {

      if (!empty($descripcio)) {
            guardarActu($conn, $id, $idincidencia, $descripcio, $visible, $temps,$data);  
            
        }
    }

     if (isset($_POST['submit_estat'])) {
   
        if (!empty($estat)) {
            actualitzarEstat($conn, $idincidencia, $estat);  
        }
        if (!empty($datafi)) {
           dataFiAct($conn, $idincidencia, $datafi);
 
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
    <link rel="stylesheet" href="estilos.css"> 
</head>

<body>

    <div class="banner">
        <h1 class="bigtitol">Actuació de la incidència</h1>
          <a href='./' class="actuacio-link">Tornar a la pàgina principal</a>
            <a href="llistat.php" class="actuacio-link">Espai de control</a>
    </div>

    <div class="actuacio-container">
        <form action="" method="post" class="actuacio-form">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id ?? '') ?>">
            <input type="hidden" name="idincidencia" value="<?= htmlspecialchars($idincidencia ?? '') ?>">
            <div class="actuacio-form-group">
                <label for="descripcio">Descripció de l'actuació (màx. 500 caràcters):</label>
                <textarea id="descripcio" name="descripcio" maxlength="500" placeholder="Escriu una descripció curta" class="actuacio-textarea"><?= htmlspecialchars($descripcio ?? '') ?></textarea>

                <label for="visible">Visible per l'usuari:
                    <input type="checkbox" id="visible" name="visible" value="1" class="actuacio-checkbox">
                </label>

                <label for="temps">Temps (minuts):</label>
                <input type="number" id="temps" name="temps" placeholder="Introdueix el temps invertit en minuts" class="actuacio-input" value="<?= htmlspecialchars($temps ?? '') ?>">

                <button type="submit" name="submit_actuacio" class="actuacio-btn">Envia actuació</button>
            </div>
        </form>

        
            <form action="" method="post" class="actuacio-form">
                <input type="hidden" name="id" value="<?= htmlspecialchars($id ?? '') ?>">
                <input type="hidden" name="idincidencia" value="<?= htmlspecialchars($idincidencia ?? '') ?>">
                <div class="actuacio-form-group">
                    <label for="estat">Estat:</label>
                    <select name="estat" id="estat" class="actuacio-select">
                        <option value="">Selecciona un estat</option>
                        <option value="1" <?= $estat == '1' ? 'selected' : '' ?>>En espera</option>
                        <option value="2" <?= $estat == '2' ? 'selected' : '' ?>>Revisant</option>
                        <option value="3" <?= $estat == '3' ? 'selected' : '' ?>>Solucionada</option>
                    </select>

                    <label for="datafi">Data fi de l'actuació:</label>
                    <input type="date" id="datafi" name="datafi" value="<?= htmlspecialchars($datafi ?? '') ?>" class="actuacio-input">

                    <button type="submit" name="submit_estat" class="actuacio-btn">Envia estat</button>
                </div>
            </form>
        

        
           
       
    </div>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const formActuacio = document.querySelector("form button[name='submit_actuacio']").closest("form");
    const textareaDescripcio = document.getElementById("descripcio");
    const botoEnviar = formActuacio.querySelector("button[name='submit_actuacio']");

    let missatgeError = document.createElement("div");
    missatgeError.className = "text-danger mt-2";
    missatgeError.style.display = "none";
    missatgeError.textContent = "La descripció és obligatòria.";

    botoEnviar.parentNode.insertBefore(missatgeError, botoEnviar);

    formActuacio.addEventListener("submit", function (e) {
      if (textareaDescripcio.value.trim() === "") {
        e.preventDefault();
        missatgeError.style.display = "block";
      } else {
        missatgeError.style.display = "none";
      }
    });
  });
</script>






</body>
<footer>
   <p> Paula Vera | Marcos Suárez | Institut Pedralbes | 2025 </p> 
  </footer>
</html>
<?php
require "conexio.php";
include "funciones.php";

$id = $_POST['id'] ?? null;
$tecnic = $_POST['tecnic'] ?? null;
$prori = $_POST['proritat'] ?? null;
$estat = $_POST['estat'] ?? null;
$dataini = $_POST['dataini'];
$User = 'Administrador';
$data = date('Y-m-d H:i:s');
$ipUsuari = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$pageUsuari = 'Modificar Incidencies';
$navegador = $_SERVER['HTTP_USER_AGENT'];
guardarLog($collection, $User, $data, $ipUsuari, $pageUsuari, $navegador);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


  if (isset($tecnic) && $tecnic !== "") {
    actualitzarTecnic($conn, $id, $tecnic);
    if (empty($dataini)) {
      $dataini = date('Y-m-d H:i:s');
      dataIniAct($conn, $id, $dataini);
    }
  }

  if (!empty($prori)) {
    actualitzarPrioritat($conn, $id, $prori);
  }
}

llegirIncidenciesAdminist($conn, $id);

?>
<!DOCTYPE html>
<html lang="ca">

<head>
  <meta charset="UTF-8">
  <title>Llistat d'incidències</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="icona.png">
</head>


<body>

  <div class="banner"><br>
    <h2 class="bigtitol" style="text-align:center;">Modificació d'incidencies</h2>
  </div>

  <form action="" method="post">
    <div class="container mt-4">
      <div id="miAlerta" class="alert alert-success mt-3 d-none" role="alert">
        Els canvis s'han enviat correctament!
      </div>
      <div class="p-3 bg-light border rounded">
        <div class="form-floating">


          <select name="tecnic" class="form-select" id="tecnic">
            <option value="">-- Selecciona un tecnic --</option>
            <option value="0" <?= $tecnic == '0' ? 'selected' : '' ?>>Sense asignar</option>
            <option value="1" <?= $tecnic == '1' ? 'selected' : '' ?>>Informatic</option>
            <option value="2" <?= $tecnic == '2' ? 'selected' : '' ?>>Manteniment</option>
            <option value="3" <?= $tecnic == '3' ? 'selected' : '' ?>>Multimedia</option>
            <option value="4" <?= $tecnic == '4' ? 'selected' : '' ?>>Mediador/a</option>


          </select>
          <label for="tecnic">Tecnic: <span class="boto"></span></label>
          <br>
        </div>
        <div class="form-floating">
          <select name="proritat" class="form-select" id="proritat">
            <option value=""> Selecciona una proritat </option>
            <option value="Sense asignar" <?= $prori == 'Sense asignar' ? 'selected' : '' ?>>Sense asignar</option>
            <option value="Critica" <?= $prori == 'Critica' ? 'selected' : '' ?>>Critica</option>
            <option value="Alta" <?= $prori == 'Alta' ? 'selected' : '' ?>>Alta</option>
            <option value="Moderada" <?= $prori == 'Moderada' ? 'selected' : '' ?>>Moderada</option>
            <option value="Baixa" <?= $prori == 'Baixa' ? 'selected' : '' ?>>Baixa</option>


          </select>
          <label for="proritat">Proritat: <span class="boto"></span></label>
          <br>
        </div>

        <div class="d-grid gap-2">
          <button class="btn btn-primary" type="submit">Enviar canvis</button>
        </div>
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
        <input type="hidden" name="dataini" value="<?= htmlspecialchars($dataini) ?>">

        <div class="container mt-4">
          <a href="./" class="btn btn-secondary me-2">Tornar a la pàgina principal</a>
          <a href="landingcontrol.php" class="btn btn-primary">Espai de control</a>
        </div>

        <script>
          const formulario = document.querySelector("form");
          const boton = formulario.querySelector("button[type='submit']");
          boton.addEventListener("click", function() {
            localStorage.setItem("mostrarAlerta", "1");
          });
          window.addEventListener("DOMContentLoaded", function() {
            if (localStorage.getItem("mostrarAlerta") === "1") {
              const alerta = document.getElementById("miAlerta");
              if (alerta) {
                alerta.classList.remove("d-none");
              }
              localStorage.removeItem("mostrarAlerta");
            }
          });
        </script>

  </form>




</body>

</html>
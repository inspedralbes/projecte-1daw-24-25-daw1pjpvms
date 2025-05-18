<!DOCTYPE html>
<html lang="ca">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consulta d'incidències</title>
  <link rel="icon" type="image/png" href="icona.png">
  <link rel="stylesheet" href="consultas.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <?php
  require "conexio.php";
  include "funciones.php";
  $User = 'Usuari';
  $data = date('Y-m-d H:i:s');
  $ipUsuari = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
  $pageUsuari = "Consulta d'incidències";
  $navegador = $_SERVER['HTTP_USER_AGENT'];
  guardarLog($collection, $User, $data, $ipUsuari, $pageUsuari, $navegador);
  mostraFooter();
  mostraHeader($pageUsuari);
  $codi = $_POST['codi'] ?? '';
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    llegirConsulta($conn, $codi);
    llegirActuUsu($conn, $codi);
    die;
  }
  ?>

<body class="consulta-page">
  <main class="contenidor">
    <h2 class="subtitol">Introdueix el teu codi d'incidència</h2>

    <div class="forms">
      <form action="" method="POST">
        <label for="codi">Codi d'incidència:</label>
        <input type="text" id="codi" name="codi" placeholder="Codi" required>

        <button class="btn btn-dark" type="submit">
          <span class="btn-txt">CONSULTAR</span>
        </button>
      </form>
    </div>
  </main>

  <script>
    const form = document.querySelector("form");
    const inputCodi = document.getElementById("codi");
    const missatge = document.createElement("div");
    missatge.className = "text-danger mt-2";
    missatge.style.display = "none";
    missatge.textContent = "Només es permeten números.";
    inputCodi.parentNode.appendChild(missatge);

    form.addEventListener("submit", function(e) {
      if (!/^\d+$/.test(inputCodi.value)) {
        e.preventDefault();
        missatge.style.display = "block";
      } else {
        missatge.style.display = "none";
      }
    });
  </script>

</body>

</html>
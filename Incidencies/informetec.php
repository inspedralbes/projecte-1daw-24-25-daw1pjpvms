<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de tecnics</title>
    <link rel="icon" type="image/png" href="icona.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<?php 
echo "<div class='container mt-4'>";
echo "<h1> Informes del gestor</h1>";
  
require "conexio.php";
include "funciones.php";

llegirInformeTec($conn);
echo "<br>";
llegirDeptInfo($conn);

?>
</body>
</html>

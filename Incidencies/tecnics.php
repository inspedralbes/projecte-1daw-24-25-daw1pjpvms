<?php
require "conexio.php";
include "funciones.php";

$id = $_POST['id'] ?? null;
$incidencia = null;
$tecnic = $_POST['tecnic'] ?? null;
$prori = $_POST['proritat'] ?? null;  
$estat = $_POST['estat'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

   $id = htmlspecialchars(trim($_POST['id']));

    if (!empty($id)) {
         $idincidencia = llegirIdTec($conn, $id); 
       
    }
   
    if (!empty($estat)) {
        actualitzarEstat($conn, $idincidencia, $estat);  
    }

}


  llegirIncidenciesTecnics($conn,$id);

?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Formulari d'incidències</title>

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
        <h1 class="bigtitol">Modificació d'incidencies</h1>
    </div>
    <form action="" method="post">

            <div>
            <label for="id">el teu id de tecnic: <span class="boto"> </span></label>
           <textarea class="insert" id="id" name="id" placeholder="Introdueix el teu ID"><?= htmlspecialchars($id ?? '') ?></textarea>
            <button class="button type1" type="submit">
                <span class="btn-txt">Envia</span>
            </div>
            <div>
            <label for="proritat">Estat: <span class="boto"></span></label>
            <select name="estat" id="estat">
                <option value=""> Selecciona un estat </option>
                <option value="1" <?= $estat == '1' ? 'selected' : '' ?>>En espera</option>
                <option value="2" <?= $estat == '2' ? 'selected' : '' ?>>Revisant</option>
                <option value="3" <?= $estat == '3' ? 'selected' : '' ?>>Solucionada</option>
            
               
            </select>
           
               
           
            <button type='submit' class='edit-btn'>Enviar canvis</button>
        

            </div>
        </form>
        <p><a href='./'>Tornar a la pàgina principal</a></p>
        <a href="llistat.php">Espai de control</a>

</body>
</html>
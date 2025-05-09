<?php
require "conexio.php";
include "funciones.php";

$id = $_POST['id'] ?? null;
$incidencia = null;
$tecnic = $_POST['tecnic'] ?? null;
$prori = $_POST['proritat'] ?? null;  
$estat = $_POST['estat'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
   
    if (isset($tecnic) && $tecnic !== "") {
        actualitzarTecnic($conn, $id, $tecnic);
    }    

    if (!empty($prori)) {
        actualitzarPrioritat($conn, $id, $prori);
    }

    if (!empty($estat)) {
        actualitzarEstat($conn, $id, $estat);  
    }
   
}

  llegirIncidenciesAdminist($conn,$id);

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
        
            <label for="tecnic">Tecnic: <span class="boto"></span></label>
            <select name="tecnic" id="tecnic">
                <option value="">-- Selecciona un tecnic --</option>
                <option value="0" <?= $tecnic == '0' ? 'selected' : '' ?>>Sense asignar</option>
                <option value="1" <?= $tecnic == '1' ? 'selected' : '' ?>>Roberto</option>
                <option value="2" <?= $tecnic == '2' ? 'selected' : '' ?>>Marta</option>
                <option value="3" <?= $tecnic == '3' ? 'selected' : '' ?>>Anna</option>
                
               
            </select>
            
     </div>
     <div> 
            <label for="proritat">Proritat: <span class="boto"></span></label>
            <select name="proritat" id="proritat">
                <option value=""> Selecciona una proritat </option>
                <option value="Sense asignar" <?= $prori == 'Sense asignar' ? 'selected' : '' ?>>Sense asignar</option>
                <option value="Critica" <?= $prori == 'Critica' ? 'selected' : '' ?>>Critica</option>
                <option value="Alta" <?= $prori == 'Alta' ? 'selected' : '' ?>>Alta</option>
                <option value="Moderada" <?= $prori == 'Moderada' ? 'selected' : '' ?>>Moderada</option>
                <option value="Baixa" <?= $prori == 'Baixa' ? 'selected' : '' ?>>Baixa</option>
               
               
            </select>
            
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
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

            </div>
        </form>
        <p><a href='./'>Tornar a la pàgina principal</a></p>
        <a href="llistat.php">Espai de control</a>

</body>
</html>
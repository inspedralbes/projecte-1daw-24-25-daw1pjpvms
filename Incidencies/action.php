<?php

$servername = "localhost";
$username = "a24pauvermac_dawpaula";
$password = "%NwAi7&0h104w|lM";
$dbname = "a24pauvermac_daw";

function guardarPersona($conn, $id, $nom, $email, $cicles)
{
    if (isset($id) && is_numeric($id) && $id > 0) {

        $sql = "UPDATE PERSONES SET nom = ?, mail = ?, cicles = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("sssi", $nom, $email, $cicles, $id);
    } else {
        $sql = "INSERT INTO PERSONES (nom, mail, cicles) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nom, $email, $cicles);
    }
    if (!$stmt->execute()) {
        die("Error en la consulta: " . $stmt->error);
    }

    $stmt->close();
}
$errors = -1;

$id = "";

$nom = "";
$nomErr = "";

$email = "";
$emailErr = "";

$cicles = "";
$ciclesErr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $errors = 0;

    if (empty($_POST['fname'])) {
        $nomErr = " El nom és obligatori ";
        $errors++;
    } else {
        $nom = $_POST['fname'];
    }

    if (empty($_POST['femail'])) {
        $emailErr = " El correu és obligatori ";
        $errors++;
    } else {
        $email = $_POST['femail'];
    }


    if (isset($_POST['curs'])) {

        $cicles =  $_POST['curs'];
    } else {

        $errors++;
        $ciclesErr = "Com a mínim s'han de seleccionar uns estudis";
    }


    if (isset($_POST['id'])) {

        $id = $_POST['id'];
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['id'])) {
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {

            die("Error en la connexió amb la base de dades: " . $conn->connect_error);
        }

        $sql = "SELECT nom, mail, cicles FROM PERSONES WHERE id = ?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("i", $_GET['id']);

        if (!$stmt->execute()) {
            die("Error executing statement: " . $stmt->error);
        }
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();
            $id = $_GET['id'];
            $nom = $row["nom"];
            $email = $row["mail"];
        
        } else {
            $errors = 1;
            $nomErr = "No s'ha trobat cap persona amb l'id $_GET[id]";
        }
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <title>Document</title>
</head>

<body>

<div class="banner"> 
    <h1 class= "bigtitol"> Formulari d'incidencies</h1>
       
    </div>
    
    
    <?php

    if ($errors == 0) {

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {

            die("Error en la connexió amb la base de dades: " . $conn->connect_error);
        }

        guardarPersona($conn, $id, $nom, $email, $cicles);


        echo "<div class = 'phpcuadre'><h1>Dades guardades $cicles</h1>";
        echo "<p><strong>$nom</strong>, moltes gràcies per inscriure't amb el correu $email</p>";
        echo "<p>Has seleccionat els estudis de: $cicles</p>";
        echo "<p><a href='./'>Tornar a la pàgina principal</a></p>";
        echo "</div>";
    } else {

    ?>

        <div>
            <h1> </h1>

            <form action="" method="post">
    <?php
    if ($errors > 0) {
        echo "<div class='error'>ATENCIÓ: Hi ha $errors errors en el formulari </div>";
    }
    ?>
    <label for="fname">Nom: <span class="boto"><?php echo $nomErr; ?></span></label>
    <input type="text" id="fname" name="fname" placeholder="El teu nom" value="<?php echo $nom; ?>">

    <label for="femail">Correu electronic: <span class="boto"><?php echo $emailErr; ?></span></label>
    <input type="email" id="femail" name="femail" placeholder="Correu@usuari" value="<?php echo $email; ?>">

    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <button class="button type1" type="submit">
        <span class="btn-txt">Envia</span>
    </button>
</form>

           
        <?php
    }
        ?>
      
        </div>

</body>

</html>

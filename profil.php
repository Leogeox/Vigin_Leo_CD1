<?php

require_once("connexion.php");

//si pas connecter diriger vers login
if(!isset($_SESSION["iduser"])) {
    header("location:login.php");
}

    // je vide ma session quand appuie sur deconnecter
if(isset($_GET["action"]) && $_GET["action"] == "deconnexion") {
    unset($_SESSION["iduser"]);
    unset($_SESSION["email"]);
    header("location:login.php"); // redirection login
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php

        echo "Vous êtes connecté avec l'adresse email " . $_SESSION["email"];
    
    ?>
    
    <a href="?action=deconnexion">Se déconnecter</a>

</body>
</html>
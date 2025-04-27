<?php

require_once("connexionprojet.php");

//si pas connecter diriger vers login
if(!isset($_SESSION["iduser"])) {
    header("location:login.php");
}

    // je vide ma session quand appuie sur deconnecter
if(isset($_GET["action"]) && $_GET["action"] == "deconnexion") {
    unset($_SESSION["iduser"]);
    unset($_SESSION["email"]);
    header("location:loginprojet.php"); // redirection login
}

////


if ($_POST) {

    $name = $_POST["name"];
    $ki = $_POST["ki"];
    $race = $_POST["race"];

    try { //creer un card
        $stmt = $pdo->prepare("INSERT INTO card (name, ki, race) 
    VALUES(:name, :ki, :race)");

        //info a ajouter
        $stmt->execute([
            "name" => $name,
            "ki" => $ki,
            "race" => $race,
        ]);

    } catch (PDOException $e) {
        echo $e->getMessage();
    }

}

//delete card
if(isset($_GET['action']) && $_GET['action'] == 'delete') {

    $idcard = $_GET['idcard'];

    try { 
        $stmt = $pdo->prepare("DELETE FROM card WHERE idcard = :idcard");

        $stmt->execute([
            "idcard" => $idcard,
        ]);

        echo "La carte a bien été supprimé !";

    } catch (PDOException $e) {
        echo $e->getMessage();
    }

}

if(isset($_GET['action']) && $_GET['action'] == 'modify') {

    //recup infos
    $idcard = $_GET['idcard'];
    $newName = 'name';
    $newKi = 'ki';
    $newRace = 'race';

    try {
        $stmt = $pdo->prepare("UPDATE card SET name = :name, ki = :ki, race = :race WHERE idcard = :idcard");
                
            //info a modifier
        $stmt->execute([
            "idcard" => $idcard,
            "name" => $newName,
            "ki" => $newKi,
            "race" => $newRace,
        ]);

        echo "La carte a bien été modifié !";

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


$stmt = $pdo->query("SELECT * FROM card"); // PDO STATEMENT
$cards = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Votre sélection de cartes Undertale favorites : suivez, admirez et complétez votre deck parfait.">
    <title>Profil</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="img/icons/favicon.png">
</head>

<body class=background id="body">

    <?php
        echo "Vous êtes connecté avec l'adresse email " . $_SESSION["email"];
    ?>
    
    <a href="?action=deconnexion">Se déconnecter</a>

    <br>
    <br>

    <!-- tableau cartes -->
    <h1>Mes cartes ajoutées</h1>

    <br>

    <table border="1">
        <thead>
            <th>Image</th>
            <th>Name</th>
            <th>Ki</th>
            <th>Race</th>
            <th>Supprimer</th>
            <th>Modifier</th>
        </thead>

        <tbody>

            <?php
            // boucle avec infos a montrer venant de la library
            foreach ($cards as $key => $card) {
                echo "<tr>";
                echo "<td>" . $card["image"] . "</td>";
                echo "<td>" . $card["name"] . "</td>";
                echo "<td>" . $card["ki"] . "</td>";
                echo "<td>" . $card["race"] . "</td>";
                echo "<td> <a href='?idcard=". $card["idcard"] . "&action=delete'> Supprimer </a> </td>";
                echo "<td> <a href='?idcard=". $card["idcard"] . "&action=modify'> Modifier </a> </td>";
                echo "</tr>";
            }

            ?>

        </tbody>
    </table>

    <br>
    <br>
    <!-- form pour creer -->
    <form method="POST">

        <label for="name">Image:</label>
        <input type="text" name="image" id="image" placeholder="Image">

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" placeholder="Name">


        <label for="ki">Ki:</label>
        <input type="number" name="ki" id="ki" placeholder="Ki">


        <label for="race">Race:</label>
        <input type="number" name="race" id="race" placeholder="Race">

        <input type="submit" value="Create card">

    </form>

    <?php if(isset($_GET['action']) && $_GET['action'] == 'modify') { ?>
    <!-- form sencer update -->
    <form method="UPDATE">

        <label for="name">Image:</label>
        <input type="text" name="image" id="image" placeholder="Image">
        
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" placeholder="Name">

        <label for="ki">Ki:</label>
        <input type="number" name="ki" id="ki" placeholder="Ki">

        <label for="race">Race:</label>
        <input type="number" name="race" id="race" placeholder="Race">

        <input type="submit" value="Modify card">
        
    </form>

    <?php } ?>

</body>
</html>
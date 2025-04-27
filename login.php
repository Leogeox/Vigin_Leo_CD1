<?php

require_once("connexion.php");

// si deja connecter diriger vers profil
if(isset($_SESSION["iduser"])) {
    header("location:profil.php");
}

if ($_POST) {

    //enleve espace
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if ($email && $password) {

        //prend info de la bdd et verifie si info existe
        $stmt = $pdo->query("SELECT * FROM user WHERE email = '$email' ");
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["iduser"] = $user["iduser"];
            $_SESSION["email"] = $user["email"];
            header("location:profil.php"); //si existe diriger vers profil
        } else {
            echo "La connexion a échoué !";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>



    <h1>Connexion</h1>

    <?php if (!isset($_SESSION["iduser"])) { ?>
        <form method="POST">

            <label for="email">Email:</label>
            <input type="text" name="email" id="email" placeholder="Email">


            <label for="password">Mot de passe:</label>
            <input type="password" name="password" id="password" placeholder="Mot de passe">

            <input type="submit" value="Connexion">

        </form>

    <?php } ?>

</body>

</html>
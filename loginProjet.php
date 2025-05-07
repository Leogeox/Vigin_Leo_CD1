<?php

require_once("connexionprojet");

// si deja connecter diriger vers profil
if(isset($_SESSION["iduser"])) {
    header("location:profil.php");
}

if ($_POST) {

    //enleve espace
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if ($email && $password) {

        //prend info de la bdd et verifie si info existe
        $stmt = $pdo->query("SELECT * FROM user WHERE email = '$email' ");
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["iduser"] = $user["iduser"];
            $_SESSION["name"] = $user["name"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["name"] = $user["name"];
            header("location:profilProjet.php"); //si existe diriger vers profil
        } else {
            echo "La connexion a échoué !";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Votre sélection de cartes Undertale favorites : suivez, admirez et complétez votre deck parfait.">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="img/icons/favicon.png">
</head>

<body class=background id="body">

    <section class="connection">
        <a href="menu.html"><img src="img/icons/logo.png" id="logo_account" alt="Icon du logo"></a>

        <?php if (!isset($_SESSION["iduser"])) { ?>
        <form method="POST" id="form">
            <h1>Welcome to DragonBall TCG</h1>

            <input type="text" name="name" id="name" autocomplete="name" placeholder="Name" class="enter" size="50">
            <input type="email" name="email" id="email" autocomplete="email" placeholder="Email" class="enter" size="50">
            <input type="password" name="password" id="password" placeholder="Password" class="enter" size="50">
            <input class="login" type="submit" value="Log In">

            <p class="form_txt">Don't have an account?</p>
            <button class="signup" ><a href="sign-up.html">Sign Up</a></button>

            <p class="border"></p>
        </form>
        <?php } ?>
    </section>
    
    <script src="form.js"></script>
</body>
</html>

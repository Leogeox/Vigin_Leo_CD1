<?php

require_once("connexion.php");

if($_POST){
    //infos
    $email = $_POST["email"];
    $password = $_POST["password"];

    //ajoute info dans la bdd
    $sql = "INSERT INTO user (email, password) VALUES(:email, :password)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT)
    ]);

    echo "Votre user a été correctement inséré en BDD";

}

?>

<br>
<br>
<form method="POST">

    <label for="email">Email:</label>
    <input type="text" name="email" id="email" placeholder="Email">


    <label for="password">Mot de Passe:</label>
    <input type="text" name="password" id="password" placeholder="Mot de passe">

    <input type="submit" value="Inscription">

</form>
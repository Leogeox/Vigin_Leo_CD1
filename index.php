<?php

require_once("connexion.php");

if ($_POST) {

    $title = $_POST["title"];
    $author = $_POST["author"];
    $date_publication = $_POST["date_publication"];
    $category = $_POST["category"];
    $disponibility = $_POST["disponibility"];

    try { //creer un book
        $stmt = $pdo->prepare("INSERT INTO book (title, author, date_publication, category_idcategory, disponibility) 
    VALUES( :title, :author, :date_publication, :category, :disponibility )");

        //info a ajouter
        $stmt->execute([
            "title" => $title,
            "author" => $author,
            "date_publication" => $date_publication,
            "category" => $category,
            "disponibility" => $disponibility,
        ]);

    } catch (PDOException $e) {
        echo $e->getMessage();
    }

}

//delette book
if(isset($_GET['action']) && $_GET['action'] == 'delete') {

    $idbook = $_GET['id_book'];

    try { 
        $stmt = $pdo->prepare("DELETE FROM book WHERE idbook = :idbook");

        $stmt->execute([
            "idbook" => $idbook,
        ]);

        echo "Le livre a bien été supprimé !";

    } catch (PDOException $e) {
        echo $e->getMessage();
    }

}

if(isset($_GET['action']) && $_GET['action'] == 'modify') {

    //recup infos
    $idbook = $_GET['id_book'];
    $newTitle = 'title';
    $newAuthor = 'author';
    $newDate_publication = 'date_publication';
    $newCategory = 'category_idcategory';
    $newDisponibility = 'disponibility';

    //sencer pv update une info (fonctionw pas :( )
    try {
        $stmt = $pdo->prepare("UPDATE book SET title = :title, author = :author, date_publication = :date_publication, category_idcategory = :category, disponibility = :disponibility WHERE idbook = :idbook");
            
        //info a modifier
        $stmt->execute([
            "title" => $newTitle,
            "author" => $newAuthor,
            "date_publication" => $newDate_publication,
            "category" => $newCategory,
            "disponibility" => $newDisponibility,
        ]);

    echo "Le livre a bien été modifié !";

    } catch (PDOException $e) {
            echo $e->getMessage();
    }
}

$stmt = $pdo->query("SELECT * FROM book"); // PDO STATEMENT
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- tableau livres -->
    <h1>Mes livres en BDD</h1>

    <table border="1">
        <thead>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Date</th>
            <th>Catégorie</th>
            <th>Disponibilité</th>
            <th>Supprimer</th>
            <th>Modifier</th>
        </thead>

        <tbody>

            <?php
            // boucle avec infos a montrer venant de la library
            foreach ($books as $key => $book) {
                echo "<tr>";
                echo "<td>" . $book["title"] . "</td>";
                echo "<td>" . $book["author"] . "</td>";
                echo "<td>" . $book["date_publication"] . "</td>";
                echo "<td>" . $book["category_idcategory"] . "</td>";
                echo "<td>" . $book["disponibility"] . "</td>";
                echo "<td> <a href='?id_book=". $book["idbook"] . "&action=delete'> Supprimer </a> </td>";
                echo "<td> <a href='?id_book=". $book["idbook"] . "&action=modify'> Modifier </a> </td>";
                echo "</tr>";
            }

            ?>

        </tbody>
    </table>

    <br>
    <br>
    <!-- form pour creer -->
    <form method="POST">

        <label for="title">Titre:</label>
        <input type="text" name="title" id="title" placeholder="Titre">


        <label for="author">Auteur:</label>
        <input type="text" name="author" id="author" placeholder="Auteur">


        <label for="date_publication">Date:</label>
        <input type="text" name="date_publication" id="date_publication">

        <label for="category">Categorie</label>
        <input type="number" name="category" id="category">


        <label for="disponibility">Disponibilité:</label>
        <input type="number" minimum="0" max="1" name="disponibility" id="disponibility">

        <input type="submit" value="Créer livre">
    </form>

    <?php if(isset($_GET['action']) && $_GET['action'] == 'modify') { ?>
    <!-- form sencer update -->
    <form method="UPDATE">
        
        <label for="title">Titre:</label>
        <input type="text" name="title" id="title" placeholder="Titre">
        
        <label for="author">Auteur:</label>
        <input type="text" name="author" id="author" placeholder="Auteur">
        
        <label for="date_publication">Date:</label>
        <input type="text" name="date_publication" id="date_publication">
        
        <label for="category">Categorie</label>
        <input type="number" name="category" id="category">
        
        <label for="disponibility">Disponibilité:</label>
        <input type="number" min="0" max="1" name="disponibility" id="disponibility">
        
        <input type="submit" value="Modifier livre">
        
    </form>

    <?php } ?>

</body>

</html>
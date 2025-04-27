<?php

require_once("connexion.php");
// Create Read Update Delete


echo '<pre>'; 
var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
// la méthode fetchALL me renvoit un tableau multi dimentionnel avec tous mes enregistrements en base
// le PDO FETCH_ASS est une constante qui me permet d'avoir en index de mes tableaux, le nom des colonnes
echo'</pre>';


/// 
/// EXEC
///

$sql = "INSERT INTO book (title, author, date_publication, category_idcategory) 
VALUES( 'Le petit prince', 'Sacha Lacombe', '1997-03-28', 1 )";

$pdo->exec($sql);

/// 
/// PREPARE & EXECUTE
///


try{
    $stmt = $pdo->prepare("INSERT INTO book (title, author, date_publication, category_idcategory) 
    VALUES( :title, :author, :date_publication, :category )");

    $stmt->execute([
        "title" => "Le rouge et le noir",
        "author" => "Standall",
        "date_publication" => "1945-01-01",
        "category" => 1,
    ]);

    $stmt->execute([
        "title" => "One piece",
        "author" => "Oda",
        "date_publication" => "1975-01-01",
        "category" => 1,
    ]);
} catch(PDOException $e) {
    echo $e->getMessage();
}

///// 
///// SELECT
/////
$stmt = $pdo->query("SELECT * FROM book"); // PDO STATEMENT
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
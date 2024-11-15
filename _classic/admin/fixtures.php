<?php
require "../inc/config.php";
$requete = $bdd->query("TRUNCATE TABLE articles");

$arrayAuteur = ["Thomas","Timéo","Alexandre","Antoine","Laura"];
$arrayTitre = ["PHP En force", "React JS une valeur sure", "C# toujours au top", "Java en baisse"];
$dateAjout = new DateTime();

for($i = 0; $i <= 200; $i++){
    shuffle($arrayAuteur);
    shuffle($arrayTitre);
    $dateAjout->modify("+1 day");
    $requete = $bdd->prepare("INSERT INTO articles (Titre, Description, DatePublication, Auteur) VALUES (:Titre, :Description, :DatePublication, :Auteur)");
    $requete->bindValue(':Titre', $arrayTitre[0]);
    $requete->bindValue(':Auteur', $arrayAuteur[0]);
    $requete->bindValue(':DatePublication', $dateAjout->format('Y-m-d'));
    $requete->bindValue(':Description', 'On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions, et empêche de se concentrer sur la mise en page elle-même. L\'avantage du Lorem Ipsum sur un texte générique comme \'Du texte. Du texte. Du texte.\' est qu\'il possède une distribution de lettres plus ou moins normale, et en tout cas comparable avec celle du français standard. De nombreuses suites logicielles de mise en page ou éditeurs de sites Web ont fait du Lorem Ipsum leur faux texte par défaut, et une recherche pour \'Lorem Ipsum\' vous conduira vers de nombreux sites qui n\'en sont encore qu\'à leur phase de construction. Plusieurs versions sont apparues avec le temps, parfois par accident, souvent intentionnellement (histoire d\'y rajouter de petits clins d\'oeil, voire des phrases embarassantes).');

    $requete->execute();

}

header("Location: /admin");
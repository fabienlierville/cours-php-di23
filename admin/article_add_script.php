<?php
require '../inc/config.php';

$requete = $bdd->prepare("INSERT INTO articles (Titre,Description,DatePublication,Auteur) VALUES (:Titre,:Description,:DatePublication,:Auteur)");
$requete->bindValue(':Titre',$_POST['Titre']);
$requete->bindValue(':Description',$_POST['Description']);
$requete->bindValue(':DatePublication',$_POST['DatePublication']);
$requete->bindValue(':Auteur',$_POST['Auteur']);
$requete->execute();

header('location:/admin');
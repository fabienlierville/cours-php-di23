<?php
require '../inc/config.php';

if(isset($_POST['Id']) && isset($_POST["Titre"]) && isset($_POST["Description"]) && isset($_POST["DatePublication"]) && isset($_POST["Auteur"])){
    $requete = $bdd->prepare("UPDATE articles SET Titre=:Titre, Description=:Description, DatePublication=:DatePublication, Auteur=:Auteur Where Id=:Id");
    $requete->bindValue(':Titre', $_POST['Titre']);
    $requete->bindValue(':Description', $_POST['Description']);
    $requete->bindValue(':DatePublication', $_POST['DatePublication']);
    $requete->bindValue(':Auteur', $_POST['Auteur']);
    $requete->bindValue(':Id', $_POST['Id']);

    $requete->execute();

    header('Location: /admin/article_update_form.php?Id='.$_POST['Id']);

}else{
    header('Location: /admin');
}
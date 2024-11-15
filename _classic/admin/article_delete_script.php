<?php
require "../inc/config.php";

if(isset($_GET["Id"])) {
    $req = $bdd->prepare("DELETE FROM articles WHERE Id = :Id");
    $req->bindValue(':Id', $_GET["Id"]);
    $req->execute();

}
header("Location:/admin");
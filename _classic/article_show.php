<?php require("./inc/config.php"); ?>
<?php
if(isset($_GET["Id"]) && !empty($_GET["Id"])){
    $requete = $bdd->prepare("SELECT * FROM articles WHERE Id = :Id");
    $requete->bindValue(":Id", $_GET["Id"]);
    $requete->execute();
    $article = $requete->fetch(PDO::FETCH_ASSOC);
}else{
    header("location:/");
}
?>
<?php require("./inc/header.php"); ?>
    <h1>Détail de l'article</h1>



    <ul>
        <li><strong>Titre :</strong> <?php echo $article["Titre"]; ?></li>
        <li><strong>Description :</strong> <?php echo strip_tags($article["Description"],["b"]); ?></li>
        <li><strong>Date de publication :</strong> <?php echo $article["DatePublication"]; ?></li>
        <li><strong>Auteur :</strong> <?php echo $article["Auteur"]; ?></li>
    </ul>
<?php require("./inc/footer.php"); ?>


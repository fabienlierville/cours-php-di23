<?php require("./inc/config.php"); ?>
<?php require("./inc/header.php"); ?>
    <h1>Bienvenue sur notre blog</h1>
    <?php
        if(isset($_POST["search"]) && !empty($_POST["search"])){
            $requete = $bdd->prepare("SELECT * FROM articles WHERE Titre like :TITREARTICLE OR Description like :DESCRIPTIONARTICLE");
            $requete->bindValue(":TITREARTICLE", "%{$_POST["search"]}%");
            $requete->bindValue(":DESCRIPTIONARTICLE", "%{$_POST["search"]}%");
            $requete->execute();
            $articles = $requete->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $requete = $bdd->query("SELECT * FROM articles");
            $articles = $requete->fetchAll(PDO::FETCH_ASSOC);
        }

        var_dump($articles);
    ?>
    <form name="recherche" method="post">
        <input type="text" placeholder="Recherche..." name="search">
        <input type="hidden" name="champinvisible" value="1234">
    </form>

<?php
var_dump($_POST);
?>
<?php require("./inc/footer.php"); ?>



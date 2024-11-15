<?php require("../inc/config.php"); ?>
<?php
 if(isset($_GET["Id"])){
     $requete = $bdd->prepare("SELECT * FROM articles WHERE Id = :Id");
     $requete->bindValue(':Id', $_GET["Id"]);
     $requete->execute();
     $article = $requete->fetch(PDO::FETCH_ASSOC);
 }else{
     header("location:/admin");
 }
?>
<?php require("../inc/header.php"); ?>
    <h1>Admin - Mise à jour d'un article</h1>

<form method="post" action="article_update_script.php">
    <input type="hidden" name="Id" value="<?php echo $article["Id"]; ?>">
    <input type="text" name="Titre" placeholder="Titre" value="<?php echo $article["Titre"]; ?>">
    <textarea name="Description"><?php echo $article["Description"]; ?></textarea>
    <input type="date" name="DatePublication" value="<?php echo $article["DatePublication"]; ?>">
    <select name="Auteur">
        <option <?php if($article["Auteur"] == "Thomas") {echo "selected"; } ?> value="Thomas">Thomas Pelligry</option>
        <option  <?php if($article["Auteur"] == "Timéo") {echo "selected"; } ?> value="Timéo">Timéo</option>
        <option  <?php if($article["Auteur"] == "Alexandre") {echo "selected"; } ?> value="Alexandre">Alexandre</option>
        <option  <?php if($article["Auteur"] == "Antoine") {echo "selected"; } ?> value="Antoine">Antoine</option>
        <option  <?php if($article["Auteur"] == "Laura") {echo "selected"; } ?> value="Laura">Laura</option>
    </select>
    <input type="submit">
</form>
<?php require("../inc/footer.php"); ?>


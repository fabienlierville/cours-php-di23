<?php require("../inc/config.php"); ?>
<?php
require "../inc/security.php";
if(!haveGoodRole(["Admin", "test"])){
    header("Location: /login.php");
    exit();
}
?>
<?php require("../inc/header.php"); ?>
    <h1>Admin - Ajouter un article</h1>

<form method="post" action="article_add_script.php">
    <input type="text" name="Titre" placeholder="Titre">
    <textarea name="Description"></textarea>
    <input type="date" name="DatePublication">
    <select name="Auteur">
        <option value="Thomas">Thomas Pelligry</option>
        <option value="Timéo">Timéo</option>
        <option value="Alexandre">Alexandre</option>
        <option value="Antoine">Antoine</option>
        <option value="Laura">Laura</option>
    </select>
    <input type="submit">
</form>
<?php require("../inc/footer.php"); ?>


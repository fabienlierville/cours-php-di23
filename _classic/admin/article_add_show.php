<?php require("../inc/config.php"); ?>
<?php require("../inc/header.php"); ?>
    <h1>Admin - Détail de l'article</h1>

    <ul>
        <li><strong>Titre :</strong> <?php echo $_POST["titre"]; ?></li>
        <li><strong>Description :</strong> <?php echo strip_tags($_POST["description"],["b"]); ?></li>
        <li><strong>Date de publication :</strong> <?php echo $_POST["datepublication"]; ?></li>
        <li><strong>Auteur :</strong> <?php echo $_POST["auteur"]; ?></li>
    </ul>
<?php require("../inc/footer.php"); ?>


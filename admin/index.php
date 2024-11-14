<?php require("../inc/config.php"); ?>
<?php
$requete = $bdd->query("SELECT * FROM articles");
$articles = $requete->fetchAll(PDO::FETCH_ASSOC);
?>
<?php require("../inc/header.php"); ?>
    <h1>Admin - Liste des articles</h1>
    <table>
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Titre</th>
            <th scope="col">Date de Publication</th>
            <th scope="col">Auteur</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>
            <?php
                foreach($articles as $article){
                    echo "<tr>";
                        echo "<th scope='row'><a href='#'>{$article["Id"]}</a></th>";
                        echo "<td>{$article["Titre"]}</td>";
                        echo "<td>{$article["DatePublication"]}</td>";
                        echo "<td>{$article["Auteur"]}</td>";
                    echo "<th scope='row'><a href='#'>&#128465;</a></th>";
                    echo "</tr>";
                 }
            ?>
        </tbody>
    </table>
<?php require("../inc/footer.php"); ?>


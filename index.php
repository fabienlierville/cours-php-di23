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
            $requete = $bdd->query("SELECT * FROM articles order by Id DESC Limit 0,10");
            $articles = $requete->fetchAll(PDO::FETCH_ASSOC);
        }
    ?>
    <form name="recherche" method="post">
        <input type="text" placeholder="Recherche..." name="search">
        <input type="hidden" name="champinvisible" value="1234">
    </form>

<table>
    <thead>
    <tr>
        <th scope="col">Titre</th>
        <th scope="col">Description</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach($articles as $article){
        echo "<tr>";
        echo "<th scope='row'></th>";
        echo "<td>{$article["Titre"]}</td>";
        echo "<td>".get_words($article["Description"],10)." <a href='/article_show.php?Id={$article["Id"]}'>Lire le suite...</a></td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
<?php
//Hash
$hash = password_hash("azerty",PASSWORD_BCRYPT,array("cost"=>10));
var_dump($hash);

if(password_verify("Azerty",$hash)){
    echo "Mot de passe valide";
}
?>
<?php require("./inc/footer.php"); ?>



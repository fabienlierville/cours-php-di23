<?php

namespace src\Controller;

use src\Model\Article;
use src\Model\BDD;

class ArticleController
{
    public function index(){
        $html = "<h1>Voici les 20 derniers articles :</h1>";
        $articles = Article::SqlGetLast(20);
        foreach ($articles as $article) {
            $html .= "<p>Titre = {$article->getTitre()}</p>";
        }
        return $html;
    }

    public function fixtiures(){
        $requete = BDD::getInstance()->prepare("TRUNCATE TABLE articles")->execute();
        $arrayAuteur = ["Thomas","Timéo","Alexandre","Antoine","Laura"];
        $arrayTitre = ["PHP En force", "React JS une valeur sure", "C# toujours au top", "Java en baisse"];
        $dateAjout = new \DateTime();

        for($i=1;$i<=200;$i++) {
            $dateAjout->modify("+1 day");
            shuffle($arrayAuteur);
            shuffle($arrayTitre);
            $article = new Article();
            $article->setTitre($arrayTitre[0])
                ->setDescription("Zypher est un langage de programmation moderne conçu pour offrir une expérience de développement puissante et flexible. Avec une syntaxe claire et concise, Zypher permet aux développeurs de créer des applications robustes et efficaces dans divers domaines, allant de l'informatique embarquée à la programmation web")
                ->setAuteur($arrayAuteur[0])
                ->setDatePublication($dateAjout);
            Article::SqlAdd($article);
        }

    }
}
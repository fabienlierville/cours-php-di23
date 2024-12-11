<?php

namespace src\Controller;

use Mpdf\Mpdf;
use src\Model\Article;
use src\Model\BDD;

class ArticleController extends AbstractController
{
    public function index(){
        $articles = Article::SqlGetLast(20);
        return $this->twig->render('Article/index.html.twig', [
            'articles' => $articles
        ]);
    }

    public function fixtures(){
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
        header('location: /');
    }

    public function show($id){
        $article = Article::SqlGetById($id);
        return $this->twig->render('Article/show.html.twig', [
            'article' => $article
        ]);
    }

    public function pdf(int $id){
        $article = Article::SqlGetById($id);
        $mpdf = new Mpdf([
            "tempDir" => $_SERVER["DOCUMENT_ROOT"]."/../var/cache/articles/".$article->getId()."/pdf",
        ]);
        $mpdf->WriteHTML($this->twig->render('Article/pdf.html.twig', [
            'article' => $article
        ]));
        $mpdf->Output();
    }
}
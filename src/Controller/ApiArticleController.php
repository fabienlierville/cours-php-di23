<?php
namespace src\Controller;

use src\Model\Article;

class ApiArticleController {
    public function __construct() {
        header("Content-type: application/json; charset=utf-8");
    }

    public function getAll() {
        if($_SERVER["REQUEST_METHOD"] != "GET") {
            header("HTTP/1.1 405 Method Not Allowed");
            return json_encode(
                [
                    "status" => "error",
                    "message" => "Get Attendu"]
            );
        }
        $articles = Article::SqlGetAll();
        return json_encode($articles);
    }

    public function add(){
        if($_SERVER["REQUEST_METHOD"] != "POST") {
            header("HTTP/1.1 405 Method Not Allowed");
            return json_encode(
                [
                    "status" => "error",
                    "message" => "Post Attendu"]
            );
        }

        // Récupération du Body en String
        $data  = file_get_contents("php://input");
        //Conversion du String en JSON
        $json = json_decode($data);

        if(empty($json)) {
            header("HTTP/1.1 400 Bad Request");
            return json_encode(
                [
                    "status" => "error",
                    "message" => "Il faut des données"]
            );
        }

        if(!isset($json->Titre) || !isset($json->Description) ) {
            header("HTTP/1.1 400 Bad Request");
            return json_encode(
                [
                    "status" => "error",
                    "message" => "Il faut des données"]
            );
        }

        $article = new Article();
        $article->setTitre($json->Titre);
        $article->setDescription($json->Description);
        $article->setAuteur($json->Auteur);
        $article->setDatePublication(new \DateTime($json->DatePublication));
        $id = Article::SqlAdd($article);
        return json_encode([
            "status" => "success",
            "Message" => "Article créé avec succès",
            "article" => $id
        ]);
    }
}
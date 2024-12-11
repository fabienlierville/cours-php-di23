<?php
namespace src\Controller;

use src\Model\Article;
use src\Service\JwtService;

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

        $jwtresult = JwtService::checkToken();
        if($jwtresult["status"] == "error") {
            return json_encode($jwtresult["message"]);
        }

        if(!in_array("Administrateur",$jwtresult["data"]->Roles)){
            return json_encode(
                [
                    "status" => "error",
                    "message" => "Vous n'avez pas le role Toto"]
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
        //Gestion de l'image
        $sqlRepository = null;
        $nomImage = null;

        if(isset($json->Image)) {
            $nomImage = uniqid().".jpg";
            //Fabriquer le répertoire d'accueil
            $dateNow = new \DateTime();
            $sqlRepository = $dateNow->format('Y/m');
            $repository = './uploads/images/' . $dateNow->format('Y/m');
            if (!is_dir($repository)) {
                mkdir($repository, 0777, true);
            }
            //Fabriquer l'image
            $ifp = fopen($repository . "/" . $nomImage, "wb");
            fwrite($ifp, base64_decode($json->Image));
            fclose($ifp);
        }

        $article = new Article();
        $article->setTitre($json->Titre);
        $article->setDescription($json->Description);
        $article->setAuteur($json->Auteur);
        $article->setDatePublication(new \DateTime($json->DatePublication));
        $article->setImageRepository($sqlRepository);
        $article->setImageFileName($nomImage);
        $id = Article::SqlAdd($article);
        return json_encode([
            "status" => "success",
            "Message" => "Article créé avec succès",
            "article" => $id
        ]);
    }

    public function search(){
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

        if(!isset($json->keyword) ) {
            header("HTTP/1.1 400 Bad Request");
            return json_encode(
                [
                    "status" => "error",
                    "message" => "Il faut des données"]
            );
        }
        $articles = Article::SqlSearch($json->keyword);
        return json_encode($articles);
    }
}
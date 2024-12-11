<?php

namespace src\Controller;

use src\Model\User;
use src\Service\JwtService;

class UserController extends AbstractController
{

    public function create(){
        if(isset($_POST["mail"]) && isset($_POST["password"]) && isset($_POST["roles"])){
            $user = new User();
            $hashpass = password_hash($_POST["password"], PASSWORD_BCRYPT, ["cost"=>12]);
            $user->setEmail($_POST["mail"])
                ->setPassword($hashpass)
                ->setRoles($_POST["roles"]);
            $id = User::SqlAdd($user);

            header("Location:/User/login");
            exit();
        }else{
            return $this->twig->render("User/create.html.twig");
        }

    }

    public function login(){
        if(isset($_POST["mail"]) && isset($_POST["password"])){
            //Requete SQL qui va cherches les info du User avec le mail
            $user = User::SqlGetByMail($_POST["mail"]);
            if($user!=null){
                //Comparer le mdp hasché avec celui saisi dans le formulaire
                if(password_verify($_POST["password"], $user->getPassword())){
                    //Créer les sessions sinon Lever une Exception
                    // Et rediriger vers /AdminArticle/list
                    $_SESSION["login"] = [
                        "Email" => $user->getEmail(),
                        "Roles" => $user->getRoles()
                    ];
                    header("Location:/AdminArticle/list");
                }else{
                    throw new \Exception("Mot de passe incorrect pour {$_POST["mail"]}");
                }
            }else{
                throw new \Exception("Aucun user avec ce mail en base");
            }
        }

        return $this->twig->render("User/login.html.twig");
    }

    public static function haveGoodRole(array $rolesCompatibles) {
        if(!isset($_SESSION["login"])){
            throw new \Exception("Vous devez vous authentifier pour accéder à cette page");
        }
        // Comparaison role par role
        $roleFound = false;
        foreach ($_SESSION["login"]["Roles"] as $role){
            if(in_array($role, $rolesCompatibles)){
                $roleFound = true;
                break;
            }
        }
        if(!$roleFound){
            throw new \Exception("Vous dn'avez pas le bon role pour accéder à cette page");
        }
    }

    public function logout()
    {
        unset($_SESSION["login"]);
        header("Location:/");
    }

    public function loginjwt()
    {
        header("Content-type: application/json; charset=utf-8");

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

        if(!isset($json->Email) || !isset($json->Password) ) {
            header("HTTP/1.1 400 Bad Request");
            return json_encode(
                [
                    "status" => "error",
                    "message" => "Il faut des données"]
            );
        }

        // Récupérer les infos du user grace à son Email
        $user = User::SqlGetByMail($json->Email);
        if($user==null) {
            header("HTTP/1.1 403 Forbiden");
            return json_encode(
                [
                    "status" => "error",
                    "message" => "Email inconnu dans notre système"]
            );
        }

        // Comparer le mot de passe
        if(!password_verify($json->Password, $user->getPassword())){
            header("HTTP/1.1 403 Forbiden");
            return json_encode(
                [
                    "status" => "error",
                    "message" => "Mot de passe incorrect"]
            );
        }

        // Retourne le JWT
        return JwtService::createToken([
           "Email" => $user->getEmail(),
           "Roles" => $user->getRoles()
        ]);


    }

}

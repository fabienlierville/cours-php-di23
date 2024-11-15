<?php
require ("./inc/config.php");

//Récupère les infos user par rapport au mail
$requete = $bdd->prepare("SELECT * FROM users WHERE Email=:Email");
$requete->execute([
    "Email" => $_POST["Email"]
]);
$user = $requete->fetch(PDO::FETCH_ASSOC);

// Compare mot de passe clair / hashé en base
// Early Return (mail invalide, mot de passe invalide)
session_start();
if(!$user){
    $_SESSION["ERROR"] = "Mail invalide";
    header("Location:/login.php");
    exit();
}
if(!password_verify($_POST["Password"], $user["Password"])){
    $_SESSION["ERROR"] = "Password invalide";
    header("Location:/login.php");
    exit();
}

// Si ok => Session "connecté"
$_SESSION["Login"] = [
    "NomPrenom" => $user["NomPrenom"],
    "Roles" => $user["Roles"],
    "UserId" => $user["Id"],
];
if(isset($_POST["RememberMe"]) && $_POST["RememberMe"] == true){
    $token = bin2hex(random_bytes(32));
    //On genere un token et on l'insert dan la table users
    // update users set token=$token where email = $_POST["Email"]
    setcookie("rememberToken", $token, time() + (86400 * 30), "/");
}
header("Location:/admin");

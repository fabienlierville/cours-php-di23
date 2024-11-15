<?php
session_start();
require('./inc/config.php');
if(isset($_COOKIE["rememberToken"])){
    $rememberToken = $_COOKIE["rememberToken"];
    // requete SQL qui select * from user where token = $rememberToken
    // Admettons qu'il y'a un Token en BDD
    $tokenBDD = "a1587c01ea9393c5ac969e0867ef9800f6ae3eb8ff41195a18d1d7c3ca22a7d6";
    if($rememberToken == $tokenBDD){
        $_SESSION["Login"] = [
            "NomPrenom" => "LIERVILLE Fabien", //Data réup en BDD
            "Roles" => json_encode(["Admin"]),
            "UserId" => 5,
        ];
        header("Location:/admin");
    }
}
require('./inc/header.php');
?>
<h1>Login</h1>

<?php
    if(isset($_SESSION['ERROR'])){
        echo "<p style='color: red'>".$_SESSION['ERROR']."</p>";
        unset($_SESSION['ERROR']);
    }
?>

<form method="post" action="login_check.php">
    <input type="email" name="Email" placeholder="Email">
    <input type="password" name="Password" placeholder="Password">
    <input type="checkbox" name="RememberMe">
    <input type="submit">
</form>

<?php require('./inc/footer.php');?>

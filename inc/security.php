<?php

function haveGoodRole(array $rolesCompatibles) :bool {
    // Par exemple pour la page ajout Article il faudra être soit Admin soit Redacteur
    //Donc dans $rolesCompatibles on enverra ["Admin","Redacteur"]
    session_start();
    if(!isset($_SESSION["Login"])){
        return false;
    }

    //Comparaison role par role
    // On a un tableau de role compatible
    // Dans la session on un tableau de role pour l'utilisateur
    $roleFound = false;
    $rolesSession = json_decode($_SESSION["Login"]["Roles"]);
    foreach($rolesSession as $role){
        if(in_array($role, $rolesCompatibles)){
            $roleFound = true;
            break;
        }
    }
    return $roleFound;
}
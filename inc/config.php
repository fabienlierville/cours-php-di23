<?php
const _DBHOSTNAME_ = "cours_php-mariadb106";
const _DBUSERNAME_ = "docker";
const _DBPASSWORD_ = "docker";
const _DBNAME_ = "docker";
const _DBPORT_ = 3306;

try {
    $bdd = new PDO("mysql:host="._DBHOSTNAME_.";port="._DBPORT_.";dbname="._DBNAME_.";charset=utf8", _DBUSERNAME_, _DBPASSWORD_);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (Exception $e){
    die("ERREUR BDD : {$e->getMessage()}");
}

function get_words($sentence, $count = 10) {
    preg_match("/(?:\w+(?:\W+|$)){0,$count}/", $sentence, $matches);
    return $matches[0];
}
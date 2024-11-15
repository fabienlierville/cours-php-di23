<?php

namespace src\Model;
use PDO;

class BDD {
    private static $_instance = null; //Instance de connexion
    private const _DBHOSTNAME_ = "cours_php-mariadb106";
    private const _DBUSERNAME_ = "docker";
    private const _DBPASSWORD_ = "docker";
    private const _DBNAME_ = "docker";
    private const _DBPORT_ = 3306;

    private function __construct(){}
    private function __clone(){}

    public static function getInstance(){
        if(is_null(self::$_instance)){
            try {
                $_instance = new PDO("mysql:host="._DBHOSTNAME_.";port="._DBPORT_.";dbname="._DBNAME_.";charset=utf8", _DBUSERNAME_, _DBPASSWORD_);
                $_instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch (Exception $e){
                die("ERREUR BDD : {$e->getMessage()}");
            }
        }
        return self::$_instance;
    }
}
<?php
use src\Controller\ErrorController;

require_once '../vendor/autoload.php';

//Autoload qui require la class demandée
spl_autoload_register(function ($class) {
    // J'obient : src\Model\Article
    // Faire un require du $class
    // unix séparé par les /, windows par des \
    $ds = DIRECTORY_SEPARATOR;
    $dir = $_SERVER['DOCUMENT_ROOT'] . $ds."..";
    $className = str_replace("\\", $ds, $class);
    $file = "{$dir}{$ds}{$className}.php";
    if(is_readable($file)) {
        require_once $file;
    }
});

// Notre internaute va afficher les pages grace aux urls suivantes :
// index.php?controller=Article&action=add
// index.php?controller=Article&action=show&id=156
// index.php?controller=User&action=login
//Routeur
$urls = explode('/', $_GET['url']);
$controller = (isset($urls[0])) ? $urls[0] : '';
$action = (isset($urls[1])) ? $urls[1] : '';
$param = (isset($urls[2])) ? $urls[2] : '';

if($controller != ''){
    try{
        $class = "src\Controller\\{$controller}Controller";

        if(class_exists($class)) {
            $controller = new $class();
            if (method_exists($controller, $action)) {
                echo $controller->$action($param);
            } else {
                throw new Exception("Action {$action} does not exist in {$class}");
            }
        }else{
            throw new Exception("Controller {$controller} does not exist");
        }
    }catch (Exception $e){
        //Todo plus tard affiche une page "Error" qui contient
        // le message d'erreur dans $e-getMessage();
        $controller = new ErrorController();
        echo $controller->show($e);
    }
}else{
    //Page par défaut
    $controller = new \src\Controller\ArticleController();
    echo $controller->index();
}




//generate Password
//$hash = password_hash("azerty",PASSWORD_BCRYPT, ["cost" => 10]);
//var_dump($hash);








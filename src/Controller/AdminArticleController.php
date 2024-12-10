<?php
namespace src\Controller;

use src\Model\Article;

class AdminArticleController extends AbstractController{
    public function list(){
        $articles = Article::SqlGetAll();
        return $this->twig->render('Admin/Article/list.html.twig', [
            'articles' => $articles
        ]);
    }

    public function delete(int $id){
        Article::SqlDelete($id);
        header('location: /?controller=AdminArticle&action=list');
    }

    public function add(){
        if(isset($_POST['Titre']) && isset($_POST['Description']))
        {
            //1. Upload Fichier
            $sqlRepository = null; // On ne fera pas X requetes SQL différentes donc on déclare les variables dès le début pour les utiliser dans la requete SQL
            $nomImage = null;

            if(!empty($_FILES['Image']['name']) ) {
                $tabExt = ['jpg', 'gif', 'png', 'jpeg'];    // Extensions autorisees
                $extension = pathinfo($_FILES['Image']['name'], PATHINFO_EXTENSION);
                // strtolower = on compare ce qui est comparage (JPEG =! jpeg)
                if (in_array(strtolower($extension), $tabExt)) {
                    // Fabrication du répertoire d'accueil façon "Wordpress" (YYYY/MM)
                    $dateNow = new \DateTime();
                    $sqlRepository = $dateNow->format('Y/m');
                    $repository = './uploads/images/' . $dateNow->format('Y/m');
                    if (!is_dir($repository)) {
                        mkdir($repository, 0777, true);
                    }
                    // Renommage du fichier (d'où l'intéret d'avoir isolé l'extension
                    $nomImage = md5(uniqid()) . '.' . $extension;

                    //Upload du fichier, voilà c'est fini !
                    move_uploaded_file($_FILES['Image']['tmp_name'], $repository . '/' . $nomImage);
                }
            }
            //2. Créer un objet Article
            $article = new Article();
            $article->setTitre($_POST['Titre']);
            $article->setDescription($_POST['Description']);
            $article->setAuteur($_POST['Auteur']);
            $article->setImageRepository($sqlRepository);
            $article->setImageFileName($nomImage);
            $article->setDatePublication(new \DateTime($_POST['DatePublication']));

            //3. Exécuter la requete SQL d'ajout (model)
            $id = Article::SqlAdd($article);

            //4. Rédiriger l'internaute sur la page liste
            header("location: /?controller=Article&action=show&param={$id}");

        }
        return $this->twig->render('Admin/Article/add.html.twig');
    }

    public function update(int $id)
    {
        $article = Article::SqlGetById($id); // On récupère l’article car il va servir autant à l’affichage du formulaire qu’au POST du formulaire
        if(isset($_POST["Titre"])){
            $sqlRepository = (isset($_POST["ImageRepository"])) ? $_POST["ImageRepository"] : null; // Si champ image actuelle alors on prend la valeur sinon null
            $nomImage = (isset($_POST["ImageFileName"])) ? $_POST["ImageFileName"] : null;
            if(isset($_FILES["Image"]["name"])){
                $extensionsAutorisee = ["jpg", "jpeg", "png"];
                $extension = pathinfo($_FILES["Image"]["name"], PATHINFO_EXTENSION);
                if(in_array($extension, $extensionsAutorisee)){
                    // Créer réperoire date "2023/12"
                    $dateNow = new \DateTime();
                    $sqlRepository = $dateNow->format("Y/m");
                    $repository = "./uploads/images/{$sqlRepository}";
                    if(!is_dir($repository)){
                        mkdir($repository,0777,true);
                    }
                    // Renommer le fichier image
                    $nomImage = uniqid().".".$extension;

                    //Envoyer le fichier dans le bon répetoire
                    move_uploaded_file($_FILES["Image"]["tmp_name"], $repository."/".$nomImage);
                }
                //Si il y'avait une image déjà en place on la vire :
                if(isset($_POST["ImageFileName"]) && $_POST["ImageFileName"] != '' && file_exists("{$_SERVER["DOCUMENT_ROOT"]}/uploads/images/{$_POST["ImageRepository"]}/{$_POST["ImageFileName"]}")){
                    unlink("{$_SERVER["DOCUMENT_ROOT"]}/uploads/images/{$_POST["ImageRepository"]}/{$_POST["ImageFileName"]}");
                }
            }

            $date = new \DateTime($_POST["DatePublication"]);
            $article->setTitre($_POST["Titre"])
                ->setDescription($_POST["Description"])
                ->setDatePublication($date)
                ->setAuteur($_POST["Auteur"])
                ->setImageRepository($sqlRepository)
                ->setImageFileName($nomImage);
            Article::SqlUpdate($article);
            header("Location:/?controller=Article&action=show&param={$id}");
            exit();
        }else{
            return $this->twig->render("Admin/Article/update.html.twig",[
                "article" => $article
            ]);
        }

    }

}
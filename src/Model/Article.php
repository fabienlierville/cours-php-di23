<?php
namespace src\Model;
use JsonSerializable;

class Article implements JsonSerializable{
    private ?int $Id = null;
    private ?String $Titre = null;
    private ?String $Description = null;
    private ?String $Auteur = null;
    private ?\DateTime $DatePublication = null;
    private ?String $ImageRepository = null;
    private ?String $ImageFileName = null;

    public function getId(): ?int
    {
        return $this->Id;
    }

    public function setId(?int $Id): Article
    {
        $this->Id = $Id;
        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(?string $Titre): Article
    {
        $this->Titre = $Titre;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): Article
    {
        $this->Description = $Description;
        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->Auteur;
    }

    public function setAuteur(?string $Auteur): Article
    {
        $this->Auteur = $Auteur;
        return $this;
    }

    public function getDatePublication(): ?\DateTime
    {
        return $this->DatePublication;
    }

    public function setDatePublication(?\DateTime $DatePublication): Article
    {
        $this->DatePublication = $DatePublication;
        return $this;
    }

    public function getImageRepository(): ?string
    {
        return $this->ImageRepository;
    }

    public function setImageRepository(?string $ImageRepository): Article
    {
        $this->ImageRepository = $ImageRepository;
        return $this;
    }

    public function getImageFileName(): ?string
    {
        return $this->ImageFileName;
    }

    public function setImageFileName(?string $ImageFileName): Article
    {
        $this->ImageFileName = $ImageFileName;
        return $this;
    }

    public static function SqlAdd(Article $article) : int
    {
        try {
            $requete = BDD::getInstance()->prepare("INSERT INTO articles (Titre,Description,DatePublication,Auteur, ImageRepository, ImageFileName) VALUES (:Titre,:Description,:DatePublication,:Auteur, :ImageRepository, :ImageFileName)");
            $requete->bindValue(':Titre',$article->getTitre());
            $requete->bindValue(':Description',$article->getDescription());
            $requete->bindValue(':DatePublication',$article->getDatePublication()?->format('Y-m-d'));
            $requete->bindValue(':Auteur',$article->getAuteur());
            $requete->bindValue(':ImageRepository',$article->getImageRepository());
            $requete->bindValue(':ImageFileName',$article->getImageFileName());
            $requete->execute();
            return BDD::getInstance()->lastInsertId();
        }catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function SqlGetLast(int $nb)
    {
        $requete = BDD::getInstance()->prepare('SELECT * FROM articles ORDER BY Id DESC LIMIT :limit');
        $requete->bindValue("limit", $nb, \PDO::PARAM_INT);
        $requete->execute();

        $articlesSql = $requete->fetchAll(\PDO::FETCH_ASSOC);
        $articlesObjet = [];
        foreach ($articlesSql as $articleSql){
            $article = new Article();
            $article->setTitre($articleSql["Titre"])
                ->setDescription($articleSql["Description"])
                ->setDatePublication(new \DateTime($articleSql["DatePublication"]))
                ->setAuteur($articleSql["Auteur"])
                ->setImageRepository($articleSql["ImageRepository"])
                ->setImageFileName($articleSql["ImageFileName"]);
            $articlesObjet[] = $article;
        }
        return $articlesObjet;


    }

    public static function SqlGetAll()
    {
        $requete = BDD::getInstance()->prepare('SELECT * FROM articles ORDER BY Id DESC');
        $requete->execute();

        $articlesSql = $requete->fetchAll(\PDO::FETCH_ASSOC);
        $articlesObjet = [];
        foreach ($articlesSql as $articleSql){
            $article = new Article();
            $article->setTitre($articleSql["Titre"])
                ->setId($articleSql["Id"])
                ->setDescription($articleSql["Description"])
                ->setDatePublication(new \DateTime($articleSql["DatePublication"]))
                ->setAuteur($articleSql["Auteur"])
                ->setImageRepository($articleSql["ImageRepository"])
                ->setImageFileName($articleSql["ImageFileName"]);
            $articlesObjet[] = $article;
        }
        return $articlesObjet;
    }

    public static function SqlDelete(int $id){
        $requete = BDD::getInstance()->prepare('DELETE FROM articles WHERE Id = :id');
        $requete->bindValue(':id',$id);
        $requete->execute();
    }

    public static function SqlGetById(int $id) : ?Article {
        $requete = BDD::getInstance()->prepare('SELECT * FROM articles WHERE Id = :id');
        $requete->bindValue(':id',$id);
        $requete->execute();
        $sqlArticle = $requete->fetch(\PDO::FETCH_ASSOC);
        $article = new Article();
        $article->setId($sqlArticle["Id"]);
        $article->setTitre($sqlArticle["Titre"]);
        $article->setDescription($sqlArticle["Description"]);
        $article->setDatePublication(new \DateTime($sqlArticle["DatePublication"]));
        $article->setAuteur($sqlArticle["Auteur"]);
        $article->setImageRepository($sqlArticle["ImageRepository"]);
        $article->setImageFileName($sqlArticle["ImageFileName"]);
        return $article;
    }


    public static function SqlUpdate(Article $article)
    {
        $requete = BDD::getInstance()->prepare("UPDATE articles SET Titre=:Titre, Description=:Description, DatePublication=:DatePublication, Auteur=:Auteur, ImageRepository=:ImageRepository, ImageFileName=:ImageFileName WHERE Id=:Id");

        $bool = $requete->execute([
            "Titre" => $article->getTitre(),
            "Description" => $article->getDescription(),
            "DatePublication" => $article->getDatePublication()->format("Y-m-d"),
            "Auteur" => $article->getAuteur(),
            "ImageRepository" => $article->getImageRepository(),
            "ImageFileName" => $article->getImageFileName(),
            "Id"=> $article->getId()
        ]);
    }

    public static function SqlSearch(string $keyword) : array {
        $requete = BDD::getInstance()->prepare('SELECT * FROM articles WHERE Titre LIKE :keyword OR Description LIKE :keyword ORDER BY Id DESC');
        $requete->bindValue(':keyword','%'.$keyword.'%');
        $requete->execute();
        $articlesSql = $requete->fetchAll(\PDO::FETCH_ASSOC);
        $articlesObjet = [];
        foreach ($articlesSql as $articleSql){
            $article = new Article();
            $article->setId($articleSql["Id"]);
            $article->setTitre($articleSql["Titre"]);
            $article->setDescription($articleSql["Description"]);
            $article->setDatePublication(new \DateTime($articleSql["DatePublication"]));
            $article->setAuteur($articleSql["Auteur"]);
            $article->setImageRepository($articleSql["ImageRepository"]);
            $article->setImageFileName($articleSql["ImageFileName"]);
            $articlesObjet[] = $article;
        }
        return $articlesObjet;
    }

    public function jsonSerialize() : mixed
    {
        return [
            'Id' => $this->Id,
            'Titre' => $this->Titre,
            'Description' => $this->Description,
            'Auteur' => $this->Auteur,
            'ImageRepository' => $this->ImageRepository,
            'ImageFileName' => $this->ImageFileName,
            'DatePublication' => $this->DatePublication->format("Y-m-d")
        ];
    }
}

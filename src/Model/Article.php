<?php
namespace src\Model;
class Article {
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

    public static function SqlAdd(Article $article)
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
}

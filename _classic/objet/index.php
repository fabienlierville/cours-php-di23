<?php
require "../inc/config.php";
require "Article.php";
use _classic\objet\Article;
$article = new Article();
$article->setTitre("Titre")
    ->setDescription("Description")
    ->setAuteur("Auteur")
    ->setDatePublication(new DateTime());

echo Article::SqlAdd($bdd, $article);
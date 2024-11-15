<?php
require "../inc/config.php";
require "Article.php";
use objet\Article;
$article = new Article();
$article->setTitre("Titre")
    ->setDescription("Description")
    ->setAuteur("Auteur")
    ->setDatePublication(new DateTime());

echo Article::SqlAdd($bdd, $article);
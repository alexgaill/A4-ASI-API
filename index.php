<?php
require "Autoloader.php";

Autoloader::register();
try {
    //code...
    $categorie = new Article();
    // $categorie->getCategories();
    $categorie->getArticle($_GET["id"]);
    // $categorie->postCategorie($_POST);
    // $categorie->deleteCategorie($_GET["id"]);
    // $categorie->updateCategorie($_POST);
} catch (\Throwable $th) {
    General::sendError($th->getCode(), $th->getMessage());
}


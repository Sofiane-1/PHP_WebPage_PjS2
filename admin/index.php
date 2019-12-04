<?php
session_start();
require_once 'autoload.php';
require_once '../class/Ingredients.class.php';
include 'include/verification.php';



$p = new WebPage('Administration');

//Affichage des flashs messages
if (isset($_SESSION["flash"])) {

    $bts = ["success" => "success", "error" => "danger"];

    $p->appendContent('
            <div class="alert alert-' . $bts[$_SESSION["flash"]["state"]] . '" role="alert">
             '. $_SESSION["flash"]["message"] .'
            </div>
           
    ');

    //Suppression de la session juste après
    unset($_SESSION["flash"]);
}





$p->appendBootstrap();
$p->appendBootstrapJS();

$p->appendContent('<h1 class="text-center">Espace d\'administration</h1>');

$p->appendContent(<<<HTML
<div class="d-flex mt-5">
    <div class="flex-column">
    <div class="d-flex flex-row">
        <h1>Liste des Pizzas</h1>
        <a href="add.php?entity=pizza"><button class="m-3 btn btn-success">Ajouter</button></a>
    </div>
HTML
);

$pizzas = Pizza::getAll();
//Création de la Table
$table = new Table(['Id','Nom','Description','Prix','Actions']);
$table->createTable();

foreach ($pizzas as $pizza){
    $name = $pizza->getLibPizza();
    $id = $pizza->getNPizza();
    $desc = $pizza->getDescPizza();
    $prix = $pizza->getPrixPizza();
    $dateCrea = $pizza->getDateCreaPizza();
    $table->addLine([$id,$name,$desc,$prix],'pizza');
    $modal = new Modal($id,'pizza','Voulez vous supprimer cette Pizza ?');
    $modal->createModal();
    $p->appendContent($modal->getModal());

}
$table->closeTable();
$p->appendContent($table->getTable());





$p->appendContent('</div>');





//Affichage du Stock des Ingrédients
$p->appendContent(<<<HTML

    <div class="ml-4 flex-column w-50">
        <div class="d-flex flex-row">
            <h2>Liste des Stocks</h2>
            <a href="add.php?entity=ingredient"><button class="m-3 btn btn-success">Ajouter</button></a>
        </div>
    


HTML
);
//Récupération des ingrédients

$ingredients = Ingredients::getAll();

//Création de la Table
$table = new Table(['Id','Nom','Stock','Prix','Actions']);
$table->createTable();

foreach ($ingredients as $ingredient){
    $table->addLine([$ingredient->getNIng(),$ingredient->getLibIng(),$ingredient->getStockIng(),$ingredient->getPrixIng()],'ingredient');
    $modal = new Modal($ingredient->getNIng(),'ingredient','Voulez vous supprimer cet Ingrédient ?');
    $modal->createModal();
    $p->appendContent($modal->getModal());

}
$table->closeTable();
$p->appendContent($table->getTable());


$p->appendContent('</div></div>');

//Modal

echo $p->toHTML();
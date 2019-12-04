<?php
require_once 'autoload.php';

$html = new WebPage();
$html->setTitle("Livreur - L'éclipza");
$html->appendBootstrap();
$html->appendToHead('<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">');
$html->appendToHead('<link rel="shortcut icon" type="image/png" href="./ressource/img/favicon.png"/>');
$html->appendContent(<<<HTML
{$html->appendHeader()}

  	<!--- Liste commandes --->
  	<div class="d-flex flex-column">
  		<h2 class="text-center p-1 bg-light border-bottom">Liste des commandes</h2>
  		<h5>En Cours de Livraison</h5>
  		<div class="d-flex flex-row p-2 justify-content-between bg-highlight border">
  			<h3>Commande n°1</h3>
  			<button type="button" class="btn btn-success"><i class="fas fa-check"></i></button>
  		</div>
        <br>
  		<h5>En Attente de Livraison</h5>
  		<div class="d-flex flex-row p-2 justify-content-between bg-highlight border">
  			<h3>Commande n°2</h3>
  			<button type="button" class="btn btn-danger"><i class="fas fa-times"></i></button>
  		</div>
  		<br>
		<h5>Livraison terminée</h5>
  		<div class="d-flex flex-row p-2 justify-content-between bg-highlight border">
  			<h3>Commande n°0</h3>
  			<button type="button" class="btn btn-danger"><i class="fas fa-times"></i></button>
  		</div>
  	</div>
    
    
{$html->appendFooter()}
HTML
);


echo $html->toHTML();
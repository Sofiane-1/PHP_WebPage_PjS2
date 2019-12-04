<?php
session_start();
require_once 'autoload.php';
include 'include/verification.php';



$html = new WebPage('Administration');

//Affichage des flashs messages
if (isset($_SESSION["flash"])) {

    $bts = ["success" => "success", "error" => "danger"];

    $html->appendContent('
            <div class="alert alert-' . $bts[$_SESSION["flash"]["state"]] . '" role="alert">
             '. $_SESSION["flash"]["message"] .'
            </div>
           
    ');

    //Suppression de la session juste après
    unset($_SESSION["flash"]);
}





$html->appendBootstrap();
$html->appendBootstrapJS();

$html->appendContent(<<<HTML

    

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
    

HTML
);



echo $html->toHTML();
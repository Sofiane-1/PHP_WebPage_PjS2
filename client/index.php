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

LE PANIER
    

HTML
);



echo $html->toHTML();
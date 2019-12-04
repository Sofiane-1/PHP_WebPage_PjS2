<?php
require_once('../autoload.php');
session_start();

if(isset($_SESSION['id']) && isset($_GET['id']) && is_numeric($_GET['id'])){
    $pizzaId = $_GET['id'];
    if(Commande::isDisponible($_SESSION['id'])){
        Commande::addCmde([null,$_SESSION['id'],null,null,"en attente",null,null]);
        $commande = Commande::getCmdeAttente($_SESSION['id']);
        LigneCommande::addLigne($pizzaId,$commande->getNCmde());

    } else {
        $commande = Commande::getCmdeAttente($_SESSION['id']);
        LigneCommande::addLigne($pizzaId,$commande->getNCmde());
    }
    FlashMessages::fsuccess("Pizza ajoutée à votre panier !");
    header('Location: /site-projet-s2/nosPizzas.php');
}
else {
    header("HTTP/1.0 403 Forbidden");
    echo('<h1>Erreur 403, Forbidden</h1>');
}

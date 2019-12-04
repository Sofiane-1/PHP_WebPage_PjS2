<?php
require_once 'autoload.php';

$html = new WebPage();
$html->setTitle("Accueil - L'éclipza");
$html->appendBootstrap();
$html->appendToHead('<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">');
$html->appendToHead('<link rel="shortcut icon" type="image/png" href="./ressource/img/favicon.png"/>');
$html->appendCss('
.fixedTop{
    position: fixed;
    top:0;
    width: 100%;
    margin-left: auto;
    margin-right: auto;
}');
$html->appendToHead('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>');

$html->appendContent(<<<HTML
    
    {$html->appendHeader()}
    
    <div class="text-warning">
        <h1 class="d-flex p-2 ">Accueil</h1>
        <hr class="bg-warning" style="width : 500px; margin:0px;">
    </div>
HTML
);

try {
    if (isset($_SESSION['id'])) {
    if(!Commande::isDisponible($_SESSION['id'])){
        $commande = Commande::getCmdeAttente($_SESSION['id']);
        $panier = LigneCommande::getLigneFromClient($commande->getNCmde(),$_SESSION['id']);
        $table = new Table(["Id","Pizza","Prix","Etat","Actions"]);
        $table->createTable();
        $somme = 0;
        foreach ($panier as $ligne){
            $pizza = Pizza::createFromId($ligne->getNPizza());
            $table->addLinePanier([$pizza->getNPizza(),$pizza->getLibPizza(),$pizza->getPrixPizza()." €",$ligne->getEtatPizza()],"pizza");
            $somme += $pizza->getPrixPizza();
            $modal = new Modal($ligne->getNPizza(),'pizza','Voulez vous supprimer cette Pizza de votre panier ?',$ligne->getNLigneCommande());
            $modal->createModalPanier();
            $html->appendContent($modal->getModal());
        }
        $table->addLinePanierTotal(["Total", $somme . " €", null,null]);
        $table->closeTable();
        $html->appendContent($table->getTable());
    } else {
        $html->appendContent("<h1>Votre panier est vide</h1>");
    }





    } else {
        $html->appendContent("<h1> Non connecté");

    }
} catch (Exception $e) {
    //$page->appendContent("<h1> Connectez vous avant toute chose !");
    echo $e->getMessage();

}

$html->appendContent(<<<HTML

{$html->appendFooter()}
HTML
);
echo $html->toHTML();
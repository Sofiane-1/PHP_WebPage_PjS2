<?php
require_once 'autoload.php';

$listeCommande = Commande::getAll();
$listeLigneCommande = LigneCommande::getAll(); 
$listePersonne = Personnel::getAll();
$lsCmde = "";


for($i = 1 ; $i <= count($listeCommande); $i++){
    $tabPizza = LigneCommande::getPizzaFromCmde($i); // Objet pizza
    $etatCmde = $listeCommande[$i-1]->getAttr("etatCmde"); // état de la commande

    if($etatCmde == "disponible"){
        $couleurCmde = "bg-success";
    }
    elseif($etatCmde == "en préparation"){
        $couleurCmde = "bg-warning";
    }
    else{
        $couleurCmde = "bg-danger";
    }

    $lsCmde .= <<<HTML
        <div class ="bg-light row">
            <div class="col-2">
            </div>
        <div class="mt-5 p-2 col-8 border border-dark rounded">
            
            <div class="row ml-2 ">
                    <div class="bg-white text-dark m-1 p-2 col-3 border border-dark">
                        Commande N°{$i}
                    <!-- Requête SQL du numéro de la commande -->
                    </div>
                    <div class="col-1">
                    </div>
                <div class="{$couleurCmde} text-white m-1 p-2 col-3 border border-dark">
                        Etat : {$etatCmde} 
                    <!-- Requête SQL du numéro de la commande -->
                </div>
                <div class="col-1">
                </div>
                
            </div>

        
    

HTML;
 
    foreach($tabPizza as $pizza){
        try {
            $pers = LigneCommande::getPers($i, $pizza->getAttr("nPizza"));
            $personne = Personnel::getFromId($pers->getNPers());
        }   
        

        catch(Exception $e){
            //echo $e->getMessage();
        }
        $lsCmde .= <<<HTML
<div class ="row">

    <div class="col-1">
    </div>


        <div class="bg-info text-dark m-4 p-2 col-6 border border-dark">
           <div class="ml-1">
                {$pizza->getLibPizza()} :  {$personne->getNomPers()} {$personne->getPnomPers()}
                
           </div>
        
           
           
           <div class="col-1">
            
           </div>
           

        </div>


        <div class="text-dark mt-3 p-3 col-3">
                <form action="commande_modif.php" method="post">
                    <input type="submit" id="{$i}" name="id" value="Pizza Réalisée">
                    <!--Changement état de la commande, de en cours a disponible.-->
                <form>
                    <!-- Requête SQL du numéro de la commande -->
            </div>
            <!-- SQL, nom de la pizza, avec ou sans modification -->

</div>

        <div class="row">
        <div class="col-1 m-1 p-1"></div>
        <div class="text-dark col-3">
                <form action="commande_modif.php" method="post">
                    <button class="btn btn-primary" type="submit" name="choixPizzaiolo" value="{$i}">Je la fais !</button>
                <form>
                    <!-- Requête SQL du numéro de la commande -->
            </div>
            <!-- SQL, nom de la pizza, avec ou sans modification -->
        </div>
HTML;
    }

    $lsCmde .= "</div></div>";
}



$html = new WebPage();
$html->setTitle("Livreur - L'éclipza");
$html->appendBootstrap();
$html->appendToHead('<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">');
$html->appendToHead('<link rel="shortcut icon" type="image/png" href="./ressource/img/favicon.png"/>');
$html->appendContent(<<<HTML

  	<!--- Liste commandes --->

<div class="container">
    <div class ="row">
        <div class="col-5">
        </div>

        <div class="text-light bg-dark mt-5 p-2 col-2 text-center border border-dark">
            Commandes
        </div>
    </div>

    {$lsCmde}
    

</div>

HTML
);


echo $html->toHTML();
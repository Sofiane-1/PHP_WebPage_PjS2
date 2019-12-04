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

$html->appendContent(<<<HTML
    <h2 class="p-2">Présentation de la Pizzeria</h2>
    <div class="justify-content-center d-flex"><p class ="text-center w-50 ">Eclipza est une entreprise rémoise fondée par les étudiants en DUT Informatique durant leurs projets de Comptabilité/ Création d'entreprise.
    Nous vendons exclusivement des pizzas venant de toute origine, vous pouvez les retrouvez en cliquant <a href="nosPizzas.php">ici</a>.
    Vous pouvez commander nos pizzas via notre site et vous faire livrer à domicile ou les retirer directement sur place.
    </p>
    </div>
    
    <h3 class="justify-content-center d-flex">Notre équipe </h3>
    <table  class="justify-content-center d-flex" >
        <tr><th class="text-center">Personnel</th><th class="text-center">Qualification</th></tr>

HTML
);

    foreach(Personnel::getAll() as $p){
        if($p->getStatutPers()=="actif"){
            $html->appendContent('<tr><td  class="text-center p-2">'.$p->getPnomPers()." ".$p->getNomPers().'</td><td class="text-center p-2">'.$p->getRolePers().'</td></tr>');
        }
    
    }
    $html->appendContent(<<<HTML
    </table>
    {$html->appendFooter()}
HTML
);


echo $html->toHTML();


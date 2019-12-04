<?php
require_once 'autoload.php';
$html = new WebPage();
$html->setTitle("Nos Pizzas - L'éclipza");
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
        <h1 class="d-flex p-2 ">Découvrez nos pizzas</h1>
        <hr class="bg-warning" style="width : 500px; margin:0px;">
    </div>
    <br>
HTML
);
//Vérification pour messages Flashs
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

$html->appendContent('<div class="row justify-content-center" >');
foreach (Pizza::getAll() as $p){
    $href = 'informationPizza.php?nPizza=' .  $p->getNPizza();
    $srcimg = 'imagePizza.php?nPizza=' .$p->getNPizza();

    $html->appendContent(<<<HTML
    <div class="border border-dark m-2 p-2 bg-light rounded" style="width:25rem;">
            <h3 class="d-flex justify-content-center">{$p->getLibPizza()}</h3>
            <img class="rounded mx-auto d-block " src="$srcimg" alt="" width="300" height="300" srcset=""> 
            <p class="d-flex justify-content-center text-center">{$p->getDescPizza()}</p>
            <div class=" d-flex flex-row justify-content-around">
            
                <a href="$href"><button type="submit" class="btn btn-success" >En savoir plus</button></a>
                <div class="border bg-dark rounded-circle p-2 text-white" >{$p->getPrixPizza()}€</div>
            </div>
    </div>

HTML
);
    }

    


     
$html->appendContent('</div>'); 
$html->appendContent(<<<HTML
    {$html->appendFooter()}
HTML
);

echo $html->toHTML();
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



if(isset($_GET['nPizza']) && !empty($_GET['nPizza'])){
    try {
        $pizzaID = $_GET['nPizza'];
        $pizza = Pizza::createFromID($pizzaID);
        $constitution = Constitution::getIng($pizzaID);
        $srcimg ='imagePizza.php?nPizza=' .$pizza->getNPizza();
        $html->appendContent(<<<HTML
    
        {$html->appendHeader()}
      
        <div class="justify-content-right d-flex   p-2"><a class="bg-primary rounded p-1 text-white" href="nosPizzas.php">Retour Nos pizzas</a></div>
        <h1 class="justify-content-center d-flex p-2">~~~~~ {$pizza->getLibPizza()}  ~~~~~</h1>
        <div class=" flex-row justify-content-around d-flex">
            <div class="justify-content-center"><img class="rounded " src="$srcimg" alt="" width="300" height="300" srcset=""></div>
            <div class=" justify-content-left d-flex"><div class=" align-self-center">{$pizza->getDescPizza()}</div></div>

HTML
    );
        $html->appendContent('<div class=" justify-content-center d-flex flex-column p-2"><div class="p-2 justify-content-center d-flex bg-dark text-light">Liste Ingrédient</div>');
        foreach ($constitution as $element) {
            $html->appendContent('<div class="bg-light p-2 border justify-content-center d-flex">'."{$element->getLibIng()}".'</div>');
        }
        $html->appendContent('</div></div>');
            
        
        
 
        
    


    $html->appendContent(<<<HTML
    <div class=" p-2 dropdown-divider"></div>
    <div class="justify-content-around d-flex">
        <a class="p-2 bg-primary text-white rounded" href="panier/add.php?id={$pizzaID}">Ajouter au panier</a>
        <!--<a class="p-2 bg-primary text-white rounded" href="#">Personnaliser</a>-->
    </div>
    <div class="p-2 dropdown-divider"></div>
HTML
);
        
    } catch (Exception $e){
        header("HTTP/1.0 404 Not Found");
        echo "<h1>Erreur 404 Page Introuvable</h1>";
    }
}
else{
    $html->appendContent(<<<HTML
    
    {$html->appendHeader()}
    <h1>Erreur, veuillez saisir une pizza !</h1>
   
HTML
);

    
}


$html->appendContent(<<<HTML
    {$html->appendFooter()}
HTML
);
echo $html->toHTML();
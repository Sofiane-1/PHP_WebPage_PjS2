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
        <h1 class="d-flex p-2 ">Information Personnelle</h1>
        <hr class="bg-warning" style="width : 500px; margin:0px;">
    </div>
    <table  class="justify-content-center d-flex" >
        <tr><th class="text-center">Information</th></tr>
HTML
);

if(isset($_SESSION['role'])){
    
    try {
        $personnel = Personnel::getFromId($_SESSION['id']);
        $html->appendContent(<<<HTML
        <table class="justify-content-center d-flex ">
            <tr><td  class="text-center p-2">Nom</td><td class="text-center p-2">{$personnel->getNomPers()}</td></tr>
            <tr><td  class="text-center p-2">Prénom</td><td class="text-center p-2">{$personnel->getPnomPers()}</td></tr>
            <tr><td  class="text-center p-2">Emploi</td><td class="text-center p-2">{$personnel->getRolePers()}</td></tr>
            <tr><td  class="text-center p-2">Statut</td><td class="text-center p-2">{$personnel->getStatutPers()}</td></tr>
            <tr><td  class="text-center p-2">Pseudo</td><td class="text-center p-2">{$personnel->getPseudoPers()}</td></tr>
        </table>
HTML
);

    } catch (Exception $e) {
        $e->getMessage();
    }
}else{
    try {
        $client = Client::getFromId($_SESSION['id']);
     
        $html->appendContent(<<<HTML
        <table class="justify-content-center d-flex ">
            <tr><td  class="text-center p-2">Nom</td><td class="text-center p-2">{$client->getNomCli()}</td></tr>
            <tr><td  class="text-center p-2">Prénom</td><td class="text-center p-2">{$client->getPnomCli()}</td></tr>
            <tr><td  class="text-center p-2">Code Postal</td><td class="text-center p-2">{$client->getCp()}</td></tr>
            <tr><td  class="text-center p-2">Ville</td><td class="text-center p-2">{$client->getVille()}</td></tr>
            <tr><td  class="text-center p-2">Adresse</td><td class="text-center p-2">{$client->getNomCli()}</td></tr>
            <tr><td  class="text-center p-2">Pseudo</td><td class="text-center p-2">{$client->getPseudoCli()}</td></tr>
        </table>
HTML
);
        
    } catch (Exception $e) {
        $e->getMessage();
    }
}


$html->appendContent(<<<HTML
</table>
    {$html->appendFooter()}
HTML
);


echo $html->toHTML();

<?php
require_once 'autoload.php';

$html = new WebPage();
$html->setTitle("Inscription - L'éclipza");
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

    <h1 class="justify-content-center d-flex p-2">~~~~~ Inscription ~~~~~</h1>
HTML
);


$postPseudo = $_POST['pseudo'] ?? null;
$postPassword1 = $_POST['password1'] ?? null;
$postPassword2 = $_POST['password2'] ?? null;
$postNom = $_POST['nomcli'] ?? null;
$postPnom = $_POST['pnomcli'] ?? null;
$postCP = $_POST['cpcli'] ?? null;
$postVille = $_POST['villecli'] ?? null;
$postAdresse = $_POST['adressecli'] ?? null;

$message = null;
$form = new Form("post", 'inscription.php');
$form->createForm();
$form->input("Nom","nomcli","text","nomcli","Votre Nom",$postNom);
$form->input("Prenom","pnomcli","text","pnomcli","Votre Prénom",$postPnom);
$form->input("Code Postal","cpcli","number","cpcli","Votre Code Postal",$postCP,"[0-9]{5}");
$form->input("Ville","villecli","text","villecli","Votre ville",$postVille);
$form->input("Adresse","adressecli","text","adressecli","Votre adresse",$postAdresse);
$form->input("Pseudo","pseudo","text","pseudo","Votre pseudo",$postPseudo);
$form->input("Mot de Passe","password1","password","password1","Votre mot de passe",$postPassword1);
$form->input("Confirmer votre mot de passe","password2","password","password2","Confirmer votre mot de passe",$postPassword2);
$form->button("S'inscrire","primary");

$form->closeForm();

$dispo =true;
foreach(Client::getAll() as $c){
    if($c->getPseudoCli() == $postPseudo){
        $dispo = false;
    }
}

if(isset($_POST['pseudo'])){
    if($dispo){
        if ($postPassword1 == $postPassword2 ) {
            $client= Client::addCli([$postNom, $postPnom, $postCP, $postVille, $postAdresse, $postPseudo, SHA1($postPassword1)]);
            
            
            $html->appendContent(Alert::alert('Réussite de l\'inscription','success'));
    
        } else {
            $html->appendContent(Alert::alert('Echec de l\'inscription - Mot de passe incorrecte','danger'));
        
        }
    }else{
        $html->appendContent(Alert::alert('Echec de l\'inscription - Pseudo déjà pris','danger'));
    
    }
}

$html->appendContent($form->getForm());





$html->appendContent(<<<HTML

    {$html->appendFooter()}
HTML
);

echo $html->toHTML();


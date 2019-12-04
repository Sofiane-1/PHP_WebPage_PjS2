<?php
require_once 'autoload.php';
$html = new WebPage();
$html->setTitle("Page Connexion");
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
//$html->appendToHead('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>');
$html->appendContent(<<<HTML
    
    {$html->appendHeader()}
    <div class="text-warning">
        <h1 class="d-flex p-2 ">Connexion</h1>
        <hr class="bg-warning" style="width : 500px; margin:0px;">
    </div>
HTML
);
$postPseudo = $_POST['pseudo'] ?? null;
$postPassword = $_POST['password'] ?? null;
$message = null;
$form = new Form("post");
$form->createForm();
$form->input("Pseudo","pseudo","text","pseudo","Votre pseudo",$postPseudo);
$form->input("Mot de Passe","password","password","password","Votre mot de passe",$postPassword);
$form->button("Se connecter","primary");

$form->closeForm();
$html->appendContent($form->getForm());



//Vérification du Formulaire

/*if(isset($_POST['btn-submit'])){
    if(isset($_POST['pseudo']) && !empty ($_POST['pseudo'])){
        if(isset($_POST['password']) && !empty($_POST['password'])){

            $personnel = Personnel::findPseudo($_POST['pseudo']);
            if($personnel == false){
                $message = "Identifiants invalides";
            } else {
                if($_POST['password'] == $personnel->getMdpPers()){
                    $_SESSION['id'] = $personnel->getNPers();
                    header('Location: index.php');
                } else {
                    $message = "Mauvais Identifiants";
                }
            }




        } else {
            $message = "Saisir un mot de passe";
        }
    } else {
        $message = "Saisir un identifiant";
    }
}

*/
$auth = new Auth('btn-submit','pseudo','password');
$auth->verifConnexion();
$html->appendContent("<h2>$message</h2>");
$html->appendContent(<<<HTML
<h2>$message</h2>
    {$html->appendFooter()}
HTML
);

echo $html->toHTML();

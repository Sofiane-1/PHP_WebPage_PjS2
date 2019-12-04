<?php

require_once 'autoload.php';

if (isset($_POST['connect']))
{
    if(isset($_POST['pseudoConnexion']) && isset($_POST['mdpConnexion']) && !empty($_POST['mdpConnexion']) && !empty($_POST['pseudoConnexion'])){
        $html = new WebPage();
        $html->setTitle("Livreur - L'éclipza");
        $html->appendContent(<<<HTML
        {$html->appendHeader()}
            <!--Corps de la page-->
            
            
        {$html->appendFooter()}
HTML
);
        
        
        echo $html->toHTML();
    }
    else{
        
        header("Location: index.php");
        return '<div class="alert alert-danger role="alert"> Identifiant et Mot de passe invalide</div>';
    }
}
else
{
    echo "Veuillez indiquer votre Pseudo et votre mot de passe ! ";
}
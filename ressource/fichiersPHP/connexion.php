<?php

require_once 'autoload.php';

session_start();
if(!isset($_SESSION['id'])){
    $connexion =<<<HTML

<div class="border border-warning rounded-pill p-2 text-warning">
    <a class="text-warning active" href="/site-projet-s2/connection.php">Se connecter</a>
    -
    <a class="text-warning active" href="/site-projet-s2/inscription.php">S'inscrire</a>
</div>
HTML;



    return $connexion;
} else {
    
    if(isset($_SESSION['role'])){
    
    try {
        $personnel = Personnel::getFromId($_SESSION['id']);
        $name = $personnel->getPseudoPers();
        
        $html = <<<HTML
            <a href="/site-projet-s2/info.php"><button type="submit" name="info" class="btn btn-primary justify-content-center ml-1">$name</button></a>
    <a href="/site-projet-s2/deconnexion.php"><button type="submit" name="disconnect" class="btn btn-danger justify-content-center ml-1">Se déconnecter</button></a>
    <a href="/site-projet-s2/panier.php"><button type="submit" name="panier" class="btn btn-info justify-content-center ml-1">Panier</button></a>

HTML;
    } catch (Exception $e) {
        $e->getMessage();
    }
}else{
    try {
        $client = Client::getFromId($_SESSION['id']);
        $name = $client->getPseudoCli();
    
        $html = <<<HTML
            <a href="/site-projet-s2/info.php"><button type="submit" name="info" class="btn btn-primary justify-content-center ml-1">$name</button></a>
<a href="/site-projet-s2/deconnexion.php"><button type="submit" name="disconnect" class="btn btn-danger justify-content-center ml-1">Se déconnecter</button></a>
<a href="/site-projet-s2/panier.php"><button type="submit" name="panier" class="btn btn-info justify-content-center ml-1">Panier</button></a>

HTML;
    } catch (Exception $e) {
        $e->getMessage();
    }
}
   

    if(Auth::verifAdmin($_SESSION['id'])){
        $html .= <<<HTML
            <a href="/site-projet-s2/admin"><button type="submit" name="admin-space" class="btn btn-info justify-content-center ml-1">Espace Admin</button></a>
HTML;

    }
    if(Auth::verifLivreur($_SESSION['id'])) {
        $html .= <<<HTML
            <a href="/site-projet-s2/livreur"><button type="submit" name="livreur-space" class="btn btn-info justify-content-center ml-1">Espace Livreur</button></a>
HTML;

    }



    if(Auth::verifPizzaiolo($_SESSION['id'])) {
        $html .= <<<HTML
            <a href="/site-projet-s2/pizzaiolo"><button type="submit" name="pizzaiolo" class="btn btn-warning justify-content-center ml-1">Vue Pizzaiolo</button></a>
HTML;

    }

    return $html;

    
}



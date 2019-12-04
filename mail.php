<?php
require_once 'autoload.php';

if(isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["email"]) && isset($_POST["objet"]) && isset($_POST["commentaire"]) ){
    if(!empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["email"]) && !empty($_POST["objet"]) && !empty($_POST["commentaire"]) ){
        $email = $_POST['email'];
        $subject= $_POST['objet'];
        $message = "test";
        $to = "christophe.jaloux@etudiant.univ-reims.fr";

        $message .= "\n L'identité du client est M. {$_POST['prenom']} {$_POST['nom']} et son adresse est $email";

        mail("christophe.jaloux@etudiant.univ-reims.fr",'tes','okgoogle');
        header("Location: index.php");
    }
} else {
    echo "ERREUR";
}
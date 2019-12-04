<?php
require_once 'autoload.php';
$html = new WebPage();
$html->setTitle("Contact - L'éclipza");
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
        <h1 class="d-flex p-2 ">Contact</h1>
        <hr class="bg-warning" style="width : 500px; margin:0px;">
    </div>
    <br>
    <div class="justify-content-center d-flex mb-3">
        <form class="w-50 "  action="mail.php" method="POST">
            <div class="form-group">
                <label>Adresse Mail</label>
                <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="adresse@mail.com" required>
            </div>
            <div class="form-group">
                <label>Nom</label>
                <input type="text" class="form-control" name="nom" placeholder="Votre Nom" required>
                <label>Prénom</label>
                <input type="text" class="form-control" name="prenom" placeholder="Votre Prénom" required>
            </div>
            <div class="form-group">
                <label>Objet</label>
                <input type="text" class="form-control" name="objet" placeholder="Nom du sujet" required>
            </div>
            <div class="form-group">
                <label>Commentaire</label>
                <textarea type="text" row="10" cols="60"  class="form-control" name="commentaire" placeholder="Votre texte" required></textarea>
            </div>
            <button type="submit" class=" justify-content-center text-white btn btn-primary">Envoyer</button>

        </form>
    </div>

HTML
);


$html->appendContent(<<<HTML
    {$html->appendFooter()}
HTML
);

echo $html->toHTML();
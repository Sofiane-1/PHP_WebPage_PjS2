<?php

require_once 'autoload.php';

if (isset($_GET['nPizza']) && !empty($_GET['nPizza'])) {
    try{
        $NPizza = $_GET['nPizza'];
        $pizza = Pizza::createFromId($NPizza);

        $img = GDImage::createFromSize(300,300);

        $img1 = GDImage::createFromString($pizza->getImg()['img']); //OK
        $size = 450;
        
        $img->copyResampled($img1,0,0,0,0,300,300,$size,$size);
        header('Content-Type: image/jpeg');
        $img->jpeg();
    }
    catch (Exception $e) {
        //header("HTTP/1.0 404 Not Found");
        echo $e->getMessage();
        echo "<h1>Erreur 404 Page Introuvable</h1>";
    }
} else {
    //header("HTTP/1.0 404 Not Found");
    echo "<h1>Saisir un album valide</h1>";
}

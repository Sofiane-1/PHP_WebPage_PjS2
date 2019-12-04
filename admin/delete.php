<?php
session_start();
require_once 'autoload.php';
include 'include/verification.php';
if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
    try{
        $id = $_GET['id'];
        if(isset($_GET['entity']) && $_GET['entity'] === "pizza"){
            $pizza = Pizza::createFromId($id);
            $pizza::delPizza($pizza->getNPizza());
        }
        elseif (isset($_GET['entity']) && $_GET['entity'] === "ingredient"){
            Ingredients::delIng($id);
        }
        FlashMessages::ferror("La suppression a bien été effectuée");
        header('Location: index.php');
    } catch (Exception $e){
        header("HTTP/1.0 404 Not Found");
        echo $e->getMessage();
    }




} else {
    header("HTTP/1.0 404 Not Found");
    echo ('<h1>Erreur 404, Page introuvable</h1>');
}


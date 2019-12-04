<?php
require ('../autoload.php');
if(isset($_GET['idCmde']) && is_numeric($_GET['idCmde'])){
    if(isset($_GET['pizza']) && is_numeric($_GET['pizza'])){
        try{
            LigneCommande::delLigne($_GET['idCmde']);
            header('Location: /site-projet-s2/panier.php');
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }
}